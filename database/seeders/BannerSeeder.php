<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Indulge in Heavenly Sweetness',
                'subtitle' => 'Handcrafted cakes, delicate pastries, and warm artisanal breads baked fresh every single morning with premium ingredients.',
                'image' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Explore Menu',
                'button_link' => '/products',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Design Your Dream Cake',
                'subtitle' => 'Unleash your creativity with our premium 3D Cake Builder. Choose your flavors, layers, and decor, and let our chefs bring it to life.',
                'image' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13636?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Customize Now',
                'button_link' => '/custom-cake',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Freshly Baked Savories & Puffs',
                'subtitle' => 'Taste the magic of warm, flaky cheese garlic breads, savory chicken puffs, and freshly-grilled paninis baked today.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Order Warm Savories',
                'button_link' => '/categories/hot-items',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $ban) {
            Banner::updateOrCreate(
                ['title' => $ban['title']],
                $ban
            );
        }
    }
}
