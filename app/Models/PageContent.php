<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = ['slug', 'title', 'body', 'meta', 'is_active'];

    protected $casts = ['meta' => 'array', 'is_active' => 'boolean'];

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }
}
