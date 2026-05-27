<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class InventoryLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'inventory_logs';

    protected $fillable = [
        'product_id', 'user_id', 'type', 'quantity_change',
        'stock_before', 'stock_after', 'reference_type', 'reference_id', 'notes',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
