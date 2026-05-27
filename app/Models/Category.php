<?php

namespace App\Models;

use App\Helpers\MediaUrl;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = [
        'name', 'slug', 'image', 'description', 'is_active', 'sort_order',
        'parent_id', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        return MediaUrl::resolve($this->image, MediaUrl::categoryFallback());
    }

    public function getProductsCountAttribute()
    {
        if (isset($this->attributes['products_count'])) {
            return (int) $this->attributes['products_count'];
        }
        if ($this->relationLoaded('products')) {
            return $this->products->count();
        }

        return $this->products()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
