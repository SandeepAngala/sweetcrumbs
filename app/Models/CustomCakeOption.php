<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCakeOption extends Model
{
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
