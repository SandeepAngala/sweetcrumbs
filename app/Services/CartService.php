<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Support\CartLine;
use Illuminate\Support\Collection;

class CartService
{
    public function getCart(?int $userId): Collection
    {
        if ($userId) {
            return Cart::where('user_id', $userId)
                ->where('saved_for_later', false)
                ->with('product.category')
                ->get();
        }

        return $this->getGuestCartLines();
    }

    public function getSavedForLater(?int $userId): Collection
    {
        if (! $userId) {
            return collect();
        }

        return Cart::where('user_id', $userId)
            ->where('saved_for_later', true)
            ->with('product.category')
            ->get();
    }

    public function addToCart(?int $userId, int $productId, int $quantity = 1): mixed
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new \Exception("Only {$product->stock} items available in stock.");
        }

        if ($userId) {
            return $this->addToDatabaseCart($userId, $product, $quantity);
        }

        return $this->addToGuestCart($productId, $quantity, $product);
    }

    public function updateQuantity(?int $userId, int $productId, int $quantity): mixed
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($userId, $productId);
        }

        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new \Exception("Only {$product->stock} items available in stock.");
        }

        if ($userId) {
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }

            return $cartItem;
        }

        $cart = $this->guestCartArray();
        $cart[$productId] = $quantity;
        $this->setGuestCartArray($cart);

        return true;
    }

    public function removeFromCart(?int $userId, int $productId): bool
    {
        if ($userId) {
            return (bool) Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();
        }

        $cart = $this->guestCartArray();
        unset($cart[$productId]);
        $this->setGuestCartArray($cart);

        return true;
    }

    public function saveForLater(?int $userId, int $productId): mixed
    {
        if (! $userId) {
            throw new \Exception('Please log in to save items for later.');
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->saved_for_later = ! $cartItem->saved_for_later;
            $cartItem->save();
        }

        return $cartItem;
    }

    public function getCartTotal(?int $userId): float
    {
        $total = 0.0;
        foreach ($this->getCart($userId) as $item) {
            $total += $item->total;
        }

        return round($total, 2);
    }

    public function getCartCount(?int $userId): int
    {
        if ($userId) {
            return (int) Cart::where('user_id', $userId)
                ->where('saved_for_later', false)
                ->sum('quantity');
        }

        return (int) array_sum($this->guestCartArray());
    }

    public function clearCart(?int $userId): void
    {
        if ($userId) {
            Cart::where('user_id', $userId)->where('saved_for_later', false)->delete();

            return;
        }

        session()->forget('guest_cart');
    }

    public function mergeGuestCartIntoUser(int $userId): void
    {
        foreach ($this->guestCartArray() as $productId => $quantity) {
            try {
                $this->addToCart($userId, (int) $productId, (int) $quantity);
            } catch (\Exception) {
                // Skip unavailable items
            }
        }

        session()->forget('guest_cart');
    }

    public function calculateTotals(?int $userId, ?float $discount = null): array
    {
        $subtotal = $this->getCartTotal($userId);
        $discount = $discount ?? (float) session('coupon_discount', 0);
        $taxRate = config('bakery.tax_rate', 0.05);
        $tax = round($subtotal * $taxRate, 2);
        $threshold = config('bakery.free_delivery_threshold', 500);
        $delivery = ($subtotal >= $threshold || $subtotal == 0)
            ? 0.00
            : config('bakery.default_delivery_charge', 50);
        $total = max(0, round($subtotal + $tax + $delivery - $discount, 2));

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_charge' => $delivery,
            'discount' => $discount,
            'total' => $total,
        ];
    }

    public function applyCoupon(string $code, float $subtotal): array
    {
        $coupon = Coupon::active()->where('code', $code)->first();

        if (! $coupon) {
            throw new \Exception('Invalid or expired coupon code.');
        }

        if (! $coupon->isValid($subtotal)) {
            throw new \Exception('Coupon terms not met (check minimum order amount).');
        }

        return [
            'coupon' => $coupon,
            'discount' => $coupon->calculateDiscount($subtotal),
        ];
    }

    protected function addToDatabaseCart(int $userId, Product $product, int $quantity): Cart
    {
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->where('saved_for_later', false)
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
                'product_id' => $product->id,
                'quantity' => $quantity,
                'saved_for_later' => false,
            ]);
        }

        return $cartItem;
    }

    protected function addToGuestCart(int $productId, int $quantity, Product $product): bool
    {
        $cart = $this->guestCartArray();
        $existing = $cart[$productId] ?? 0;
        $newQuantity = $existing + $quantity;

        if ($product->stock < $newQuantity) {
            throw new \Exception("Cannot add more. Max stock available is {$product->stock}.");
        }

        $cart[$productId] = $newQuantity;
        $this->setGuestCartArray($cart);

        return true;
    }

    protected function guestCartArray(): array
    {
        return session('guest_cart', []);
    }

    protected function setGuestCartArray(array $cart): void
    {
        session(['guest_cart' => $cart]);
    }

    protected function getGuestCartLines(): Collection
    {
        $lines = collect();

        foreach ($this->guestCartArray() as $productId => $quantity) {
            $product = Product::with('category')->find($productId);
            if ($product && $quantity > 0) {
                $lines->push(new CartLine($product, (int) $quantity));
            }
        }

        return $lines;
    }
}
