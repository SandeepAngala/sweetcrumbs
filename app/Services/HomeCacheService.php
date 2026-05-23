<?php

namespace App\Services;

use App\Helpers\BakerySettings;
use Illuminate\Support\Facades\Cache;

class HomeCacheService
{
    public const KEYS = [
        'home_banners',
        'home_categories',
        'home_hot_selling',
        'home_trending_desserts',
        'home_mocktails',
        'home_coffee',
        'home_ice_creams',
        'home_chef_picks',
        'home_bestsellers',
        'home_testimonials',
        'home_blogs',
        'home_offers',
    ];

    public static function forgetAll(): void
    {
        foreach (self::KEYS as $key) {
            Cache::forget($key);
        }
        foreach (['api.cms.settings', 'api.cms.faqs', 'api.cms.gallery', 'api.cms.offers', 'api.cms.banners'] as $key) {
            Cache::forget($key);
        }
        BakerySettings::clearCache();
    }
}
