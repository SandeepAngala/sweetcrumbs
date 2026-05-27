<?php

namespace App\Services;

use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        protected CartService $cartService,
        protected InventoryService $inventoryService,
        protected DeliveryTrackingService $deliveryTrackingService
    ) {}

    public function createOrder(mixed $userId, array $data): Order
    {
        return DB::transaction(function () use ($userId, $data) {
            $cartItems = $this->cartService->getCart($userId);
            if ($cartItems->isEmpty()) {
                throw new \Exception('Cannot place order. Your shopping cart is empty.');
            }

            $subtotal = $this->cartService->getCartTotal($userId);

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product '{$item->product->name}' does not have enough stock.");
                }
            }

            $discount = 0.00;
            $couponId = null;

            if (! empty($data['coupon_code'])) {
                $couponData = $this->cartService->applyCoupon($data['coupon_code'], $subtotal);
                $discount = $couponData['discount'];
                $couponId = $couponData['coupon']->id;
                $couponData['coupon']->increment('used_count');
            }

            $taxRate = config('bakery.tax_rate', 0.05);
            $tax = round($subtotal * $taxRate, 2);
            $freeThreshold = config('bakery.free_delivery_threshold', 500);
            $deliveryCharge = $subtotal >= $freeThreshold ? 0.00 : config('bakery.default_delivery_charge', 50);
            $total = ($subtotal + $tax + $deliveryCharge) - $discount;

            $paymentMethod = $data['payment_method'] ?? 'cod';
            $isCod = $paymentMethod === 'cod';

            $order = Order::create([
                'user_id' => $userId,
                'uuid' => (string) Str::uuid(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_charge' => $deliveryCharge,
                'discount' => $discount,
                'total' => $total,
                'coupon_id' => $couponId,
                'payment_method' => $paymentMethod,
                'payment_status' => $isCod ? 'pending' : 'pending',
                'delivery_date' => $data['delivery_date'] ?? now()->addDay()->toDateString(),
                'delivery_time_slot' => $data['delivery_time_slot'] ?? 'Morning 9-12',
                'address_id' => $data['address_id'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $this->deliveryTrackingService->assignTrackingNumber($order);

            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?: $item->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'total' => $item->total,
                ]);

                $this->inventoryService->deductForOrder($item->product, $item->quantity, $order->id, $userId);
            }

            if ($couponId) {
                CouponUsage::create([
                    'coupon_id' => $couponId,
                    'user_id' => $userId,
                    'order_id' => $order->id,
                    'discount_amount' => $discount,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $data['transaction_id'] ?? 'PAY-'.strtoupper(Str::random(10)),
                'payment_method' => $paymentMethod,
                'amount' => $order->total,
                'status' => $isCod ? 'pending' : 'pending',
            ]);

            $this->deliveryTrackingService->addTrackingEvent($order, 'pending', 'Order placed successfully');

            $this->cartService->clearCart($userId);

            $pointsRate = config('bakery.loyalty_points_per_rupee', 0.1);
            $order->user->increment('loyalty_points', (int) floor($order->total * $pointsRate));

            $order->user->notify(new OrderPlaced($order));

            return $order->load(['items.product', 'address']);
        });
    }

    public function updateStatus(mixed $orderId, string $status, mixed $staffId = null): Order
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;

        if ($staffId) {
            $order->assigned_staff_id = $staffId;
        }

        if ($status === 'delivered') {
            $order->payment_status = $order->payment_method === 'cod' ? 'paid' : $order->payment_status;
        }

        $order->save();

        app(DeliveryTrackingService::class)->addTrackingEvent($order, $status);

        return $order->fresh();
    }

    public function cancelOrder(Order $order, mixed $userId = null): Order
    {
        if (in_array($order->status, ['delivered', 'cancelled'], true)) {
            throw new \Exception('This order cannot be cancelled.');
        }

        return DB::transaction(function () use ($order, $userId) {
            foreach ($order->items as $item) {
                $this->inventoryService->restoreFromCancellation(
                    $item->product,
                    $item->quantity,
                    $order->id,
                    $userId
                );
            }

            $order->update(['status' => 'cancelled']);
            app(DeliveryTrackingService::class)->addTrackingEvent($order, 'cancelled', 'Order cancelled');

            return $order->fresh();
        });
    }
}
