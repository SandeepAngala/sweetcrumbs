<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;

class CartService
{
    public function getCart($userId)
    {
        return Cart::where('user_id', $userId)
            ->where('saved_for_later', false)
            ->with('product')
            ->get();
    }

    public function getSavedForLater($userId)
    {
        return Cart::where('user_id', $userId)
            ->where('saved_for_later', true)
            ->with('product')
            ->get();
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        if ($product->stock < $quantity) {
            throw new \Exception("Only {$product->stock} items available in stock.");
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                throw new \Exception("Cannot add more. Max stock available is {$product->stock}.");
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'saved_for_later' => false
            ]);
        }

        return $cartItem;
    }

    public function updateQuantity($userId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($userId, $productId);
        }

        $product = Product::findOrFail($productId);
        if ($product->stock < $quantity) {
            throw new \Exception("Only {$product->stock} items available in stock.");
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return $cartItem;
    }

    public function removeFromCart($userId, $productId)
    {
        return Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function saveForLater($userId, $productId)
    {
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->saved_for_later = !$cartItem->saved_for_later;
            $cartItem->save();
        }

        return $cartItem;
    }

    public function getCartTotal($userId)
    {
        $cartItems = $this->getCart($userId);
        $total = 0.00;
        foreach ($cartItems as $item) {
            $total += $item->total;
        }
        return $total;
    }

    public function getCartCount($userId)
    {
        return Cart::where('user_id', $userId)->where('saved_for_later', false)->sum('quantity');
    }

    public function clearCart($userId)
    {
        return Cart::where('user_id', $userId)->where('saved_for_later', false)->delete();
    }

    public function applyCoupon($code, $subtotal)
    {
        $coupon = Coupon::active()->where('code', $code)->first();

        if (!$coupon) {
            throw new \Exception("Invalid or expired coupon code.");
        }

        if (!$coupon->isValid($subtotal)) {
            throw new \Exception("Coupon terms not met (check minimum order amount).");
        }

        return [
            'coupon' => $coupon,
            'discount' => $coupon->calculateDiscount($subtotal)
        ];
    }
}
