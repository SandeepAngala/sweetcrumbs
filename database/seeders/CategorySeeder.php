<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'hot-items',
                'name' => 'Signature Chai & Hot Items',
                'description' => 'Fresh-brewed masala chai, karivepaku tea, ginger chai, and hot café snacks.',
                'image' => 'https://images.unsplash.com/photo-1563822249361-3b327edf2d3d?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'sweets-desserts',
                'name' => 'Tea-Time Snacks & Sweets',
                'description' => 'Bun maska, biscuits, light sweets, and evening treats with your brew.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'soft-drinks',
                'name' => 'Cold Drinks',
                'description' => 'Chilled sodas, bottled water, and refreshing coolers.',
                'image' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'mocktails',
                'name' => 'Mocktails & Coolers',
                'description' => 'Fruit coolers, mint infusions, and sparkling specials.',
                'image' => 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'slug' => 'premium-coffees',
                'name' => 'Premium Coffee & Filter Tea',
                'description' => 'Filter coffee, espresso drinks, and specialty tea pours.',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'slug' => 'ice-creams',
                'name' => 'Ice Creams & Desserts',
                'description' => 'Creamy scoops, sundaes, and chilled desserts.',
                'image' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            $slug = $cat['slug'];
            unset($cat['slug']);
            Category::updateOrCreate(['slug' => $slug], $cat);
        }
    }
}
