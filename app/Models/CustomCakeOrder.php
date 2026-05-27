<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CustomCakeOrder extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'custom_cake_orders';

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'cake_type', 'size', 'flavor', 'filling',
        'decoration', 'message_on_cake', 'delivery_date', 'special_instructions', 'budget', 'status', 'images'
    ];

    protected $casts = [
        'images' => 'array',
        'budget' => 'decimal:2',
        'delivery_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
