<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
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
