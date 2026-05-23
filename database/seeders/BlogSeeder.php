<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $authorId = $admin ? $admin->id : 1;

        $blogs = [
            [
                'title' => 'The Art of Lamination: How to Bake Perfect French Croissants',
                'content' => 'Building the perfect flaky croissant requires patience, cold temperatures, and premium ingredients. Butter lamination is the secret behind those beautiful honeycomb layers. In this guide, Chef Sandeep breaks down the science of rolling, folding, and proving croissant dough to get that ultimate bakery-style crunch and buttery melt...',
                'excerpt' => 'Discover the scientific secrets behind folding perfect buttery layers for classic French croissants.',
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Baking Secrets',
                'tags' => ['croissant', 'french pastry', 'baking tips', 'lamination'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Demystifying Wild Yeast Sourdough Fermentation',
                'content' => 'Unlike commercial bread, wild sourdough relies on a living ecosystem of wild yeasts and lactobacilli. This natural fermentation process slowly pre-digests gluten and breaks down phytic acid, making sourdough incredibly healthy and easy to digest. Here, we outline our 36-hour slow fermentation technique...',
                'excerpt' => 'Learn how slow wild yeast fermentation creates the tangiest, healthiest sourdough loaves.',
                'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Artisanal Breads',
                'tags' => ['sourdough', 'wild yeast', 'fermentation', 'healthy bread'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Choosing the Right Flour for Your Baking Masterpieces',
                'content' => 'Flour is the foundation of baking, but not all flours are created equal. High-protein bread flour builds strong gluten structures ideal for chewy sourdough, while low-protein pastry and cake flours yield tender crumbs perfect for delicate cupcakes and biscuits. In this article, we explain flour gluten dynamics...',
                'excerpt' => 'Bread flour vs. cake flour vs. pastry flour: learn when and why to use each.',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Ingredient Science',
                'tags' => ['flour', 'baking science', 'baking tips', 'pastry'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDay(),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($blog['title'])],
                $blog
            );
        }
    }
}
