<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService,
        protected PaymentService $paymentService
    ) {}

    public function index()
    {
        $userId = auth()->id();
        $cartItems = $this->cartService->getCart($userId);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Your shopping cart is empty.');
        }

        $addresses = Address::where('user_id', $userId)->get();
        $totals = $this->cartService->calculateTotals($userId);
        $couponCode = session('coupon_code', '');
        $paymentOnlineEnabled = config('bakery.razorpay.key') || config('bakery.stripe.key');

        return view('checkout.index', compact('cartItems', 'addresses', 'totals', 'couponCode', 'paymentOnlineEnabled'));
    }

    public function store(Request $request)
    {
        $allowedPayments = ['cod', 'upi'];
        if (config('bakery.razorpay.key')) {
            $allowedPayments[] = 'razorpay';
        }
        if (config('bakery.stripe.key')) {
            $allowedPayments[] = 'stripe';
        }

        $request->validate([
            'address_id' => 'required_without:new_address|exists:addresses,id',
            'payment_method' => 'required|in:'.implode(',', $allowedPayments),
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time_slot' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500',
            'new_address' => 'nullable|array',
            'new_address.label' => 'required_with:new_address|string|max:50',
            'new_address.address_line_1' => 'required_with:new_address|string|max:255',
            'new_address.city' => 'required_with:new_address|string|max:100',
            'new_address.state' => 'required_with:new_address|string|max:100',
            'new_address.zip_code' => 'required_with:new_address|string|max:10',
        ]);

        try {
            $data = $request->all();
            $userId = auth()->id();

            if ($request->filled('new_address')) {
                $address = Address::create(array_merge(
                    $request->input('new_address'),
                    ['user_id' => $userId, 'country' => 'India']
                ));
                $data['address_id'] = $address->id;
            }

            $data['coupon_code'] = session('coupon_code');

            if (in_array($data['payment_method'], ['razorpay', 'upi', 'stripe'], true)) {
                if (empty($data['transaction_id']) || $data['transaction_id'] !== session('verified_payment_id')) {
                    throw new \Exception('Payment verification failed or was not completed. Please try again.');
                }
            }

            $order = $this->orderService->createOrder($userId, $data);

            if (in_array($data['payment_method'], ['razorpay', 'upi', 'stripe'], true)) {
                // Payment was verified in session, mark as successful
                if ($order->payment) {
                    $order->payment->update([
                        'status' => 'success',
                        'response_data' => [
                            'razorpay_order_id' => $data['razorpay_order_id'] ?? null,
                            'razorpay_signature' => $data['razorpay_signature'] ?? null,
                        ]
                    ]);
                }
                $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
                session()->forget('verified_payment_id');
            }

            session()->forget(['coupon_code', 'coupon_discount']);

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order was successfully created!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function success($orderNumber)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('order_number', $orderNumber)
            ->with(['items.product', 'address'])
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
