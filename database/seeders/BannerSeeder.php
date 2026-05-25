<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Mana Ooru Mana Tea',
                'subtitle' => 'Premium South Indian chai, filter coffee, and café snacks — brewed fresh at our Arumbaka tea lounge, open daily for travelers and locals.',
                'image' => 'https://images.unsplash.com/photo-1571934811356-798df2168c42?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Explore Menu',
                'button_link' => '/products',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Signature Chai & Snacks',
                'subtitle' => 'Karivepaku chai, ginger masala tea, bun maska, and hot savories — the perfect pause on NH 216.',
                'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Order Chai',
                'button_link' => '/categories/hot-items',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Café Coolers & Evening Brews',
                'subtitle' => 'Iced teas, mocktails, and premium filter coffee crafted for every mood — dine in or take away.',
                'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'View Beverages',
                'button_link' => '/categories/premium-coffees',
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
