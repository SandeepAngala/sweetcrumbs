<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hot Items',
                'description' => 'Sizzling, freshly-baked savory delights, warm garlic breads, gourmet puffs, and oven-fresh snacks.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sweets & Desserts',
                'description' => 'Exquisite hand-crafted luxury cakes, melt-in-your-mouth pastries, artisanal donuts, and signature fusion desserts.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Soft Drinks',
                'description' => 'Chilled premium sodas, refreshing sparkling iced teas, energizing cold beverages, and crystal clear mineral water.',
                'image' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Mocktails',
                'description' => 'Vibrant, sparkling hand-shaken fruit coolers, refreshing mint infusions, and signature tropical blends.',
                'image' => 'https://images.unsplash.com/photo-1570598912132-0ba1cc95247c?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Premium Coffees',
                'description' => 'Gourmet double-shot espresso beverages, velvety lattes, and hand-pulled luxury specialty cold and hot coffees.',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Ice Creams',
                'description' => 'Luxurious, creamy gourmet sundae bowls, premium double-scoops, and rich Belgian cocoa fudge delights.',
                'image' => 'https://images.unsplash.com/photo-1501443762994-82bd5dace89a?q=80&w=800&auto=format&fit=crop',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat['name'])],
                $cat
            );
        }
    }
}
