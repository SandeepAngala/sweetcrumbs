<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class SavedPaymentMethod extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'saved_payment_methods';

    protected $fillable = [
        'user_id', 'provider', 'token', 'last_four', 'brand', 'is_default', 'meta',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
