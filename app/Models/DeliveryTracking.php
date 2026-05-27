<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\HandlesNullableDecimals;

class DeliveryTracking extends Model
{
    use HandlesNullableDecimals;
    protected $connection = 'mongodb';
    protected $collection = 'delivery_trackings';

    protected $fillable = [
        'order_id', 'status', 'note', 'latitude', 'longitude', 'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
