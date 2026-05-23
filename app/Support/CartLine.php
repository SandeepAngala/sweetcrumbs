<?php

namespace App\Support;

use App\Models\Product;

class CartLine
{
    public function __construct(
        public Product $product,
        public int $quantity,
        public bool $saved_for_later = false,
        public ?int $product_id = null,
    ) {
        $this->product_id = $product_id ?? $product->id;
    }

    public function getTotalAttribute(): float
    {
        $price = $this->product->discount_price ?: $this->product->price;

        return (float) $price * $this->quantity;
    }
}
