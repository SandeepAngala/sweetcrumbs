<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $userId = auth()->id();
        $cartItems = $this->cartService->getCart($userId);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Your shopping cart is empty.');
        }

        $addresses = Address::where('user_id', $userId)->get();
        $subtotal = $this->cartService->getCartTotal($userId);
        $tax = round($subtotal * 0.05, 2);
        $delivery = ($subtotal >= 500 || $subtotal == 0) ? 0.00 : 50.00;
        $discount = session('coupon_discount', 0.00);
        $couponCode = session('coupon_code', '');
        $total = ($subtotal + $tax + $delivery) - $discount;
        if ($total < 0) {
            $total = 0.00;
        }

        $totals = [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_charge' => $delivery,
            'discount' => $discount,
            'total' => $total
        ];

        return view('checkout.index', compact('cartItems', 'addresses', 'totals', 'couponCode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required_without:new_address|exists:addresses,id',
            'payment_method' => 'required|in:cod,stripe,razorpay',
            'delivery_date' => 'required|date|after_or_equal:today',
            'delivery_time_slot' => 'required|string',
            'notes' => 'nullable|string|max:500',
            // fields if user inputs a new address inline
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

            // Create new address if requested
            if ($request->filled('new_address')) {
                $address = Address::create(array_merge(
                    $request->input('new_address'),
                    ['user_id' => $userId]
                ));
                $data['address_id'] = $address->id;
            }

            // Bind coupon from session
            $data['coupon_code'] = session('coupon_code');

            // Process order via order service
            $order = $this->orderService->createOrder($userId, $data);

            // Forget session coupons
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
