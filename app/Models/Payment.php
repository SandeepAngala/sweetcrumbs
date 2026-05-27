<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\HandlesNullableDecimals;

class Payment extends Model
{
    use HandlesNullableDecimals;
    protected $connection = 'mongodb';
    protected $collection = 'payments';

    protected $fillable = ['order_id', 'transaction_id', 'payment_method', 'amount', 'status', 'response_data'];

    protected $casts = [
        'amount' => 'decimal:2',
        'response_data' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
