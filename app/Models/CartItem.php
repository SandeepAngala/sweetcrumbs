<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class CartItem extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cart_items';

    protected $fillable = [
        'cart_session_id', 'product_id', 'quantity', 'saved_for_later',
    ];

    protected $casts = [
        'saved_for_later' => 'boolean',
        'quantity' => 'integer',
    ];

    public function cartSession(): BelongsTo
    {
        return $this->belongsTo(CartSession::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute(): float
    {
        $price = $this->product->discount_price ?: $this->product->price;

        return (float) $price * $this->quantity;
    }
}
