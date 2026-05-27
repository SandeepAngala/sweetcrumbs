<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\HandlesNullableDecimals;

class OrderItem extends Model
{
    use HandlesNullableDecimals;
    protected $connection = 'mongodb';
    protected $collection = 'order_items';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total'];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
