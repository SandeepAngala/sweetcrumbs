<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Re-applies branding, banners, categories, and CMS after rebrand.
 */
class BrandRefreshSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            CmsSeeder::class,
            CategorySeeder::class,
            BannerSeeder::class,
        ]);
    }
}
