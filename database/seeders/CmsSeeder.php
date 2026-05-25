<?php

namespace Database\Seeders;

use App\Models\CustomCakeOption;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HomepageOffer;
use App\Models\PageContent;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedFaqs();
        $this->seedGallery();
        $this->seedTeam();
        $this->seedOffers();
        $this->seedPageContent();
        $this->seedCustomCakeOptions();
    }

    protected function seedSettings(): void
    {
        $settings = [
            ['key' => 'store_address', 'value' => 'M/s Sri Sai Hariharan Filling Station, Sy No 419/2, NH 216, Chandolu Cherukupalli Rd, Arumbaka, Bapatla, Guntur - 522309, Andhra Pradesh', 'group' => 'contact'],
            ['key' => 'footer_address', 'value' => 'Arumbaka, Guntur — NH 216 (Mana Ooru Mana Tea)', 'group' => 'contact'],
            ['key' => 'google_maps_link', 'value' => 'https://share.google/h8dNyeSgTNanDuS2x', 'group' => 'contact'],
            ['key' => 'opening_hours', 'value' => 'Open 24 Hours', 'group' => 'contact'],
            ['key' => 'map_embed_url', 'value' => 'https://www.google.com/maps?q=16.03690084,80.66422922&hl=en&z=16&output=embed', 'group' => 'contact'],
            ['key' => 'footer_about', 'value' => 'Mana Ooru Mana Tea — premium chai, filter coffee, and café snacks at our NH 216 tea lounge in Arumbaka.', 'group' => 'general'],
            ['key' => 'promo_text', 'value' => 'Subscribe for chai offers and 10% off your first order.', 'group' => 'marketing'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/manaoorumanatea', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/manaoorumanatea', 'group' => 'social'],
            ['key' => 'social_pinterest', 'value' => 'https://pinterest.com/manaoorumanatea', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/manaoorumanatea', 'group' => 'social'],
            ['key' => 'default_product_image', 'value' => '/images/placeholder-product.svg', 'group' => 'media'],
            ['key' => 'shop_status', 'value' => 'open', 'group' => 'general'],
            ['key' => 'faq_delivery_radius_km', 'value' => '15', 'group' => 'delivery', 'type' => 'integer'],
            ['key' => 'delivery_slots', 'value' => json_encode([
                'Morning (8:00 AM - 11:00 AM)',
                'Noon (12:00 PM - 3:00 PM)',
                'Evening (4:00 PM - 7:00 PM)',
            ]), 'group' => 'delivery', 'type' => 'json'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }

    protected function seedFaqs(): void
    {
        $faqs = [
            ['category' => 'orders', 'question' => 'How far do you deliver?', 'answer' => 'We deliver within 15 km of our boutique. Orders above the free delivery threshold qualify for complimentary delivery.', 'sort_order' => 1],
            ['category' => 'orders', 'question' => 'What are your delivery charges?', 'answer' => 'Standard delivery applies below the free threshold. Exact amounts are shown at checkout based on your cart total.', 'sort_order' => 2],
            ['category' => 'products', 'question' => 'Do you offer eggless options?', 'answer' => 'Yes! Many of our cakes and pastries can be prepared eggless. Mention it in order notes or contact us before ordering.', 'sort_order' => 3],
            ['category' => 'custom', 'question' => 'How early should I book a custom cake?', 'answer' => 'We recommend at least 48–72 hours for custom designs. Wedding and large tier cakes may require 1–2 weeks.', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }

    protected function seedGallery(): void
    {
        $items = [
            ['title' => 'Royal Velvet Celebration Cake', 'description' => 'Four layers of velvety red sponge with raspberry coulis.', 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=600', 'category' => 'cakes', 'sort_order' => 1],
            ['title' => 'Classic Parisian Butter Croissant', 'description' => 'Flaky, buttery laminated pastry.', 'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=600', 'category' => 'pastries', 'sort_order' => 2],
            ['title' => 'Artisanal Wild Sourdough', 'description' => 'Natural fermentation, caramelized crust.', 'image' => 'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?q=80&w=600', 'category' => 'breads', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            GalleryItem::firstOrCreate(['title' => $item['title']], $item);
        }
    }

    protected function seedTeam(): void
    {
        $members = [
            ['name' => 'Chef Sandeep', 'role' => 'Founder & Executive Pastry Chef', 'bio' => 'Trained in Paris under world-renowned master bakers. Loves playing with complex textures and organic sugars.', 'image' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=400&auto=format&fit=crop', 'sort_order' => 1],
            ['name' => 'Sarah Jenkins', 'role' => 'Head Bread Artisan', 'bio' => 'Our sourdough queen. Sarah nurtures a 65-year-old starter inherited from her grandmother with absolute devotion.', 'image' => 'https://images.unsplash.com/photo-1581299894007-aaa50297cf16?q=80&w=400&auto=format&fit=crop', 'sort_order' => 2],
            ['name' => 'Marcus Vance', 'role' => 'Master Chocolatier', 'bio' => 'Obsessed with cacao origins and silky mirror glazes. Ensures our dark chocolate truffles are pure perfection.', 'image' => 'https://images.unsplash.com/photo-1607990283143-e81e7a2c93ab?q=80&w=400&auto=format&fit=crop', 'sort_order' => 3],
        ];

        foreach ($members as $member) {
            TeamMember::firstOrCreate(['name' => $member['name']], $member);
        }
    }

    protected function seedOffers(): void
    {
        $offers = [
            ['badge' => 'MORNING ENERGIZE', 'title' => 'The Parisian Awakening', 'description' => 'Classic Butter Croissant with double espresso Cappuccino.', 'price' => 219, 'compare_price' => 279, 'icon_classes' => 'fa-mug-hot fa-bread-slice', 'button_link' => '/products?category=premium-coffees', 'sort_order' => 1],
            ['badge' => 'AFTERNOON DELIGHT', 'title' => 'Gourmet Dolce & Mint', 'description' => 'Tiramisu cup with Spearmint Mint Cooler mocktail.', 'price' => 329, 'compare_price' => 399, 'icon_classes' => 'fa-cake-candles fa-leaf', 'button_link' => '/products?category=sweets-desserts', 'sort_order' => 2],
            ['badge' => 'ROYAL FESTIVAL', 'title' => 'Sizzling Lava & Fudge', 'description' => 'Chocolate Lava Cake with Belgian Chocolate Ice Cream.', 'price' => 319, 'compare_price' => 389, 'icon_classes' => 'fa-fire fa-cookie-bite', 'button_link' => '/products?category=sweets-desserts', 'sort_order' => 3],
        ];

        foreach ($offers as $offer) {
            HomepageOffer::firstOrCreate(['title' => $offer['title']], $offer);
        }
    }

    protected function seedPageContent(): void
    {
        PageContent::firstOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'Our Sweet Journey',
                'body' => 'Founded by Chef Sandeep in 2018, MANA OORU MANA TEA Bakery began as a tiny kitchen table experiment fueled by a big dream and a single bag of organic French flour.',
                'meta' => [
                    'established' => '2018',
                    'headline' => 'Where Every Crumb Tells a Story',
                    'subtitle' => 'The Story of Passion, Flour, and Edible Artistry',
                    'hero_image' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=800&auto=format&fit=crop',
                    'story_paragraphs' => [
                        'Founded by Chef Sandeep in 2018, MANA OORU MANA TEA Bakery began as a tiny kitchen table experiment fueled by a big dream and a single bag of organic French flour. Our goal has always been simple: to elevate daily moments with extraordinary, hand-rolled confections that look like fine art and taste like heaven.',
                        'We believe in slow baking—the quiet rhythm of natural fermentation, the precise lamination of cold butter, and the warm aroma of caramelized crusts wafting through the early morning air. Every ingredient we choose is ethically sourced, from local grass-fed butter to organic, single-origin dark chocolate.',
                    ],
                    'values' => [
                        ['icon' => 'fa-wheat-awn', 'title' => 'Uncompromising Ingredients', 'description' => 'We source only the finest raw ingredients—organic flours, real AOP French butter, fresh farm-direct fruits, and raw honeycomb. No preservatives, ever.'],
                        ['icon' => 'fa-palette', 'title' => 'Edible Artistry', 'description' => 'Every pastry is detailed by hand. From complex chocolate mirror glazes to delicate sugar flowers and gold leaves, our desserts are designed to stun.'],
                        ['icon' => 'fa-heart', 'title' => 'Warm Hospitality', 'description' => 'Baking is an act of sharing love. Whether you purchase a single warm butter croissant or a grand wedding cake, we serve you with joy and gratitude.'],
                    ],
                    'timeline' => [
                        ['year' => '2018', 'title' => 'The Humble Beginning', 'description' => 'Chef Sandeep rents a tiny garage in Sweet Town, baking simple macarons and selling them at local farmers markets.', 'icon' => 'fa-seedling', 'side' => 'left'],
                        ['year' => '2020', 'title' => 'First Boutique Café', 'description' => 'We open our flagship bakery and café doors. Gourmet food lovers queue around the block for hot butter croissants.', 'icon' => 'fa-store', 'side' => 'right'],
                        ['year' => '2023', 'title' => 'Award Winning Pastries', 'description' => 'Awarded "Best Artisanal Bakery in the State" for our outstanding French lamination and wild sourdough loaves.', 'icon' => 'fa-trophy', 'side' => 'left'],
                        ['year' => '2026', 'title' => 'The Digital Bakery', 'description' => 'Launching a fully premium digital ordering experience, complete with live tracking, custom cake builder, and loyalty perks.', 'icon' => 'fa-laptop', 'side' => 'right'],
                    ],
                ],
            ]
        );
    }

    protected function seedCustomCakeOptions(): void
    {
        $options = [
            ['group' => 'cake_type', 'label' => 'Celebration / Birthday Cake', 'value' => 'Birthday', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'cake_type', 'label' => 'Luxury Multi-Tier Wedding Cake (+₹500)', 'value' => 'Wedding', 'price_addon' => 500, 'sort_order' => 2],
            ['group' => 'cake_type', 'label' => 'Elegant Anniversary Cake (+₹200)', 'value' => 'Anniversary', 'price_addon' => 200, 'sort_order' => 3],
            ['group' => 'cake_type', 'label' => 'Playful Baby Shower Cake (+₹100)', 'value' => 'Baby Shower', 'price_addon' => 100, 'sort_order' => 4],
            ['group' => 'size', 'label' => '1.0 kg (Serves 8-10) - Base ₹1,200', 'value' => '1 kg', 'price_addon' => 1200, 'sort_order' => 1],
            ['group' => 'size', 'label' => '1.5 kg (Serves 12-15) - Base ₹1,800', 'value' => '1.5 kg', 'price_addon' => 1800, 'sort_order' => 2],
            ['group' => 'size', 'label' => '2.0 kg (Serves 16-20) - Base ₹2,400', 'value' => '2.0 kg', 'price_addon' => 2400, 'sort_order' => 3],
            ['group' => 'size', 'label' => '3.0 kg (Serves 25-30) - Base ₹3,600', 'value' => '3.0 kg', 'price_addon' => 3600, 'sort_order' => 4],
            ['group' => 'size', 'label' => '5.0 kg (Serves 40-50) - Base ₹6,000', 'value' => '5.0 kg', 'price_addon' => 6000, 'sort_order' => 5],
            ['group' => 'shape', 'label' => 'Traditional Round', 'value' => 'Round', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'shape', 'label' => 'Modern Square (+₹100)', 'value' => 'Square', 'price_addon' => 100, 'sort_order' => 2],
            ['group' => 'shape', 'label' => 'Romantic Heart-Shaped (+₹200)', 'value' => 'Heart', 'price_addon' => 200, 'sort_order' => 3],
            ['group' => 'flavor', 'label' => 'Premium Madagascar Vanilla Bean', 'value' => 'Vanilla Bean', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'flavor', 'label' => 'Belgian Dark Chocolate Truffle (+₹150)', 'value' => 'Dark Chocolate Truffle', 'price_addon' => 150, 'sort_order' => 2],
            ['group' => 'flavor', 'label' => 'Gourmet Royal Red Velvet (+₹200)', 'value' => 'Royal Velvet', 'price_addon' => 200, 'sort_order' => 3],
            ['group' => 'flavor', 'label' => 'Golden Salted Caramel Pecan (+₹250)', 'value' => 'Salted Caramel Pecan', 'price_addon' => 250, 'sort_order' => 4],
            ['group' => 'filling', 'label' => 'Standard Cream Filling (No charge)', 'value' => 'None', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'filling', 'label' => 'Fresh Raspberry Coulis (+₹100)', 'value' => 'Fresh Raspberry Coulis', 'price_addon' => 100, 'sort_order' => 2],
            ['group' => 'filling', 'label' => 'Silky Dark Chocolate Ganache (+₹120)', 'value' => 'Chocolate Ganache', 'price_addon' => 120, 'sort_order' => 3],
            ['group' => 'filling', 'label' => 'House Salted Caramel Spread (+₹80)', 'value' => 'Salted Caramel', 'price_addon' => 80, 'sort_order' => 4],
        ];

        foreach ($options as $opt) {
            CustomCakeOption::firstOrCreate(
                ['group' => $opt['group'], 'value' => $opt['value']],
                $opt
            );
        }
    }
}
