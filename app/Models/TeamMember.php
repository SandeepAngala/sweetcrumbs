<?php

namespace App\Models;

use App\Helpers\MediaUrl;
use MongoDB\Laravel\Eloquent\Model;

class TeamMember extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'team_members';

    protected $fillable = ['name', 'role', 'bio', 'image', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function getImageUrlAttribute(): string
    {
        return MediaUrl::resolve($this->image, MediaUrl::heroFallback());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
