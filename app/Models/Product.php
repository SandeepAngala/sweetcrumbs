<?php

namespace App\Models;

use App\Helpers\MediaUrl;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'price', 'discount_price',
        'images', 'category_id', 'ingredients', 'nutritional_info',
        'is_featured', 'is_trending', 'is_bestseller', 'stock', 'sku', 'status'
    ];

    protected $casts = [
        'images' => 'array',
        'nutritional_info' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'is_bestseller' => 'boolean',
        'stock' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'SCB-' . strtoupper(Str::random(8));
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    // Accessors
    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getAverageRatingAttribute()
    {
        if (isset($this->attributes['reviews_avg_rating'])) {
            return round((float) ($this->attributes['reviews_avg_rating'] ?? 0), 1);
        }
        if ($this->relationLoaded('reviews')) {
            return round((float) ($this->reviews->avg('rating') ?? 0), 1);
        }

        return round((float) ($this->reviews()->avg('rating') ?? 0), 1);
    }

    public function getPrimaryImageAttribute()
    {
        $img = null;
        if (is_array($this->images) && count($this->images) > 0) {
            $img = $this->images[0];
        } else {
            $img = Setting::get('default_product_image');
        }

        return MediaUrl::resolve($img);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
