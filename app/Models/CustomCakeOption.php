<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\HandlesNullableDecimals;

class CustomCakeOption extends Model
{
    use HandlesNullableDecimals;
    protected $connection = 'mongodb';
    protected $collection = 'custom_cake_options';

    protected $fillable = ['group', 'label', 'value', 'price_addon', 'sort_order', 'is_active'];

    protected $casts = [
        'price_addon' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
