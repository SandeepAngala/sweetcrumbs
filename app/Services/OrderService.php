<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder($userId, array $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            $cartItems = $this->cartService->getCart($userId);
            if ($cartItems->isEmpty()) {
                throw new \Exception("Cannot place order. Your shopping cart is empty.");
            }

            $subtotal = $this->cartService->getCartTotal($userId);
            
            // Check stock of all products
            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Product '{$item->product->name}' is out of stock or does not have enough stock available.");
                }
            }

            $discount = 0.00;
            $couponId = null;

            if (!empty($data['coupon_code'])) {
                try {
                    $couponData = $this->cartService->applyCoupon($data['coupon_code'], $subtotal);
                    $discount = $couponData['discount'];
                    $couponId = $couponData['coupon']->id;
                    
                    // Increment coupon usage
                    $couponData['coupon']->increment('used_count');
                } catch (\Exception $e) {
                    // Suppress or handle coupon errors gracefully
                }
            }

            $tax = round($subtotal * 0.05, 2); // 5% GST
            $deliveryCharge = $subtotal >= 500 ? 0.00 : 50.00; // free delivery above 500
            $total = ($subtotal + $tax + $deliveryCharge) - $discount;

            $order = Order::create([
                'user_id' => $userId,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_charge' => $deliveryCharge,
                'discount' => $discount,
                'total' => $total,
                'coupon_id' => $couponId,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => ($data['payment_method'] ?? 'cod') === 'cod' ? 'pending' : 'paid',
                'delivery_date' => $data['delivery_date'] ?? now()->addDay()->toDateString(),
                'delivery_time_slot' => $data['delivery_time_slot'] ?? 'Morning 9-12',
                'address_id' => $data['address_id'] ?? null,
                'notes' => $data['notes'] ?? null
            ]);

            // Save order items & decrement product stock
            foreach ($cartItems as $item) {
                $price = $item->product->discount_price ?: $item->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'total' => $item->total
                ]);

                // Decrement stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create primary payment record
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $data['transaction_id'] ?? 'COD-' . strtoupper(Str::random(10)),
                'payment_method' => $order->payment_method,
                'amount' => $order->total,
                'status' => $order->payment_status === 'paid' ? 'success' : 'pending',
            ]);

            // Clear the user's cart
            $this->cartService->clearCart($userId);

            // Add loyalty points (1 point per 10 rupees spent)
            $pointsEarned = floor($order->total / 10);
            $order->user->increment('loyalty_points', $pointsEarned);

            return $order;
        });
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        
        if ($status === 'delivered') {
            $order->payment_status = 'paid';
        }
        
        $order->save();
        return $order;
    }
}
// Helper snippet
class Str {
    public static function random($length = 16) {
        return bin2hex(random_bytes($length / 2));
    }
}
