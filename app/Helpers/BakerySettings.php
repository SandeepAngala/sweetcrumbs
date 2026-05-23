<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class BakerySettings
{
    public static function all(): array
    {
        return Cache::remember('bakery.settings.all', 3600, function () {
            $keys = [
                'store_name', 'store_email', 'store_phone', 'store_address',
                'opening_hours', 'map_embed_url', 'promo_text', 'footer_about',
                'social_instagram', 'social_facebook', 'social_pinterest', 'social_youtube',
                'default_product_image', 'shop_status', 'delivery_slots',
                'tax_rate', 'free_delivery_threshold', 'delivery_charge',
                'loyalty_points_per_rupee', 'faq_delivery_radius_km',
            ];

            $settings = [];
            foreach ($keys as $key) {
                $settings[$key] = Setting::get($key, config("bakery.{$key}"));
            }

            $settings['currency_symbol'] = config('bakery.currency_symbol', '₹');
            $settings['tax_rate'] = $settings['tax_rate'] ?? config('bakery.tax_rate', 0.05);
            $settings['tax_percent'] = round((float) $settings['tax_rate'] * 100);

            if (is_string($settings['delivery_slots'] ?? null)) {
                $settings['delivery_slots'] = json_decode($settings['delivery_slots'], true) ?: [];
            }

            return $settings;
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::all()[$key] ?? $default;
    }

    public static function clearCache(): void
    {
        Cache::forget('bakery.settings.all');
    }
}
