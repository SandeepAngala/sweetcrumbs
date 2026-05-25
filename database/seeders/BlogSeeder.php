<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $authorId = $admin ? $admin->id : 1;

        $bakerySlugs = [
            'the-art-of-lamination-how-to-bake-perfect-french-croissants',
            'demystifying-wild-yeast-sourdough-fermentation',
            'choosing-the-right-flour-for-your-baking-masterpieces',
        ];
        Blog::whereIn('slug', $bakerySlugs)->delete();

        $blogs = [
            [
                'title' => 'Benefits of Masala Chai: Spice, Warmth & Wellness',
                'content' => 'Masala chai blends cardamom, ginger, cinnamon, and strong Assam tea for a cup that wakes you up and soothes you at once. At Mana Ooru Mana Tea we slow-boil spices before adding milk so every sip is balanced — not bitter, not overly sweet. Learn how each spice supports digestion and why highway travelers swear by a fresh kadai pour.',
                'excerpt' => 'Why South Indian masala chai is more than a drink — it is daily comfort and balanced spice.',
                'image' => 'https://images.unsplash.com/photo-1571934811356-798df2168c42?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Tea Brewing Secrets',
                'tags' => ['masala chai', 'spices', 'wellness', 'south indian'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'Perfect Evening Tea Pairings for NH 216 Travelers',
                'content' => 'Evening at the tea lounge means ginger chai with hot puffs, or karivepaku tea with bun maska. We pair strength of brew with snack weight — light biscuits for mild chai, spicy puffs for bold ginger. Here is how we build combos that feel complete without being heavy before a long drive.',
                'excerpt' => 'Ginger chai, puffs, and bun maska — pairings our evening regulars love.',
                'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Café Pairings',
                'tags' => ['evening chai', 'snacks', 'combos', 'pairings'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(4),
            ],
            [
                'title' => 'Traditional South Indian Filter Coffee at Our Lounge',
                'content' => 'Filter coffee needs the right decoction ratio, fresh milk, and a brisk pour between davara and tumbler. We roast locally, brew in stainless filters, and serve foamy, aromatic coffee that stands beside our chai menu. This guide walks through grind, bloom time, and why pre-heating vessels matters.',
                'excerpt' => 'From decoction to tumbler — how we pour authentic filter coffee.',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Filter Coffee',
                'tags' => ['filter coffee', 'decoction', 'south indian', 'coffee'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'How We Prepare Signature Karivepaku & Ginger Chai',
                'content' => 'Karivepaku (curry leaf) chai is earthy and aromatic; ginger chai hits sharp and warming. Our team bruises fresh leaves, simmers ginger with jaggery when requested, and never rushes the milk roll. Small batches keep flavor honest — the same standard we have held since our first kettle on NH 216.',
                'excerpt' => 'Behind the counter: fresh leaves, ginger, and slow milk rolls.',
                'image' => 'https://images.unsplash.com/photo-1563822249361-3b327edf2d3d?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Tea Brewing Secrets',
                'tags' => ['karivepaku', 'ginger chai', 'signature', 'brewing'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Best Snacks with Tea: Bun Maska to Evening Puffs',
                'content' => 'Tea-time snacks should complement, not overpower, your cup. Bun maska loves milky masala chai; savory puffs match ginger brews; biscuits pair with lighter karivepaku tea. We bake and fry in small cycles so shelves stay fresh for morning commuters and night drivers alike.',
                'excerpt' => 'Bun maska, biscuits, and puffs — what to order with each brew.',
                'image' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Tea-Time Snacks',
                'tags' => ['bun maska', 'puffs', 'snacks', 'tea time'],
                'is_published' => true,
                'published_at' => Carbon::now()->subDay(),
            ],
            [
                'title' => 'Mint Coolers & Fruit Infusions for Sunny Afternoons',
                'content' => 'When the sun is high on NH 216, guests reach for mint coolers and citrus infusions. We muddle fresh mint, keep ice clean, and balance sweetness so the drink refreshes without masking tea-house character. Mocktails here are crafted for quick service and big sips.',
                'excerpt' => 'Coolers and infusions that refresh without leaving the tea lounge vibe.',
                'image' => 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=800&auto=format&fit=crop',
                'author_id' => $authorId,
                'category' => 'Mocktails & Coolers',
                'tags' => ['mocktails', 'mint', 'coolers', 'summer'],
                'is_published' => true,
                'published_at' => Carbon::now(),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($blog['title'])],
                $blog
            );
        }
    }
}
