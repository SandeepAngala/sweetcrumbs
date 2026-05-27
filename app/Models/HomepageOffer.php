<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Concerns\HandlesNullableDecimals;

class HomepageOffer extends Model
{
    use HandlesNullableDecimals;
    protected $connection = 'mongodb';
    protected $collection = 'homepage_offers';

    protected $fillable = [
        'badge', 'title', 'description', 'price', 'compare_price',
        'icon_classes', 'button_text', 'button_link', 'product_ids',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'product_ids' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getSavingsAttribute(): ?float
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return (float) ($this->compare_price - $this->price);
        }

        return null;
    }
}
