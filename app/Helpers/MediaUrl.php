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

    public static function resolve(?string $path, ?string $fallback = null): string
    {
        if (empty($path)) {
            return $fallback ?? static::placeholder();
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            if (config('bakery.prefer_local_media', false) && Str::contains($path, 'unsplash.com')) {
                return $fallback ?? static::placeholder();
            }

            if (Str::contains($path, 'unsplash.com')) {
                $base = explode('?', $path)[0];

                return $base.'?auto=format,webp&fit=crop&w=800&q=75';
            }

            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return asset(ltrim($path, '/'));
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        return $fallback ?? static::placeholder();
    }
}
