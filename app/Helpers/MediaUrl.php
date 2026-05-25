<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUrl
{
    public static function placeholder(): string
    {
        return asset('images/placeholder-product.svg');
    }

    public static function heroFallback(): string
    {
        return asset('images/fallback-hero-tea.svg');
    }

    public static function categoryFallback(): string
    {
        return asset('images/fallback-category-tea.svg');
    }

    public static function blogFallback(): string
    {
        return asset('images/fallback-blog-tea.svg');
    }

    public static function resolve(?string $path, ?string $fallback = null): string
    {
        $fallback ??= static::placeholder();

        if (empty($path)) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            if (Str::contains($path, 'unsplash.com')) {
                $base = explode('?', $path)[0];

                return $base.'?auto=format,webp&fit=crop&w=800&q=80';
            }

            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return $fallback;
    }
}
