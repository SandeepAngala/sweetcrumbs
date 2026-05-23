<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'saved_for_later'];

    protected $casts = [
        'quantity' => 'integer',
        'saved_for_later' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute()
    {
        $price = $this->product->discount_price ?: $this->product->price;
        return $price * $this->quantity;
    }
}
