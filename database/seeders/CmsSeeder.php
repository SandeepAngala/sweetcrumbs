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
            ['category' => 'orders', 'question' => 'How far do you deliver from Arumbaka?', 'answer' => 'We deliver within 15 km of our NH 216 tea lounge. Orders above the free delivery threshold qualify for complimentary delivery.', 'sort_order' => 1],
            ['category' => 'orders', 'question' => 'What are your delivery charges?', 'answer' => 'Standard delivery applies below the free threshold. Exact amounts are shown at checkout based on your cart total.', 'sort_order' => 2],
            ['category' => 'products', 'question' => 'Can I customize a tea combo?', 'answer' => 'Yes — visit Tea Bar to choose chai style, snack, serving size, and optional cooler. Our team confirms your order shortly after.', 'sort_order' => 3],
            ['category' => 'custom', 'question' => 'How early should I book a large combo tray?', 'answer' => 'For family trays or event combos, please request at least 24 hours ahead so we can brew fresh chai and prepare snacks.', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }

    protected function seedGallery(): void
    {
        $items = [
            ['title' => 'Masala Chai at Sunrise', 'description' => 'Fresh kadai brew with cardamom and ginger.', 'image' => 'https://images.unsplash.com/photo-1571934811356-798df2168c42?q=80&w=600', 'category' => 'chai', 'sort_order' => 1],
            ['title' => 'Bun Maska & Filter Coffee', 'description' => 'Classic highway tea-time pairing.', 'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=600', 'category' => 'café', 'sort_order' => 2],
            ['title' => 'Evening Ginger Chai', 'description' => 'Bold ginger boil served with hot puffs.', 'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=600', 'category' => 'evening', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            GalleryItem::firstOrCreate(['title' => $item['title']], $item);
        }
    }

    protected function seedTeam(): void
    {
        $members = [
            ['name' => 'Sandeep Angala', 'role' => 'Founder & Tea Master', 'bio' => 'Built Mana Ooru Mana Tea on NH 216 with honest chai, filter coffee, and warm highway hospitality.', 'image' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=400&auto=format&fit=crop', 'sort_order' => 1],
            ['name' => 'Kavya Menon', 'role' => 'Head Chai Brewer', 'bio' => 'Expert in masala, karivepaku, and ginger chai — every cup balanced for strength and aroma.', 'image' => 'https://images.unsplash.com/photo-1581299894007-aaa50297cf16?q=80&w=400&auto=format&fit=crop', 'sort_order' => 2],
            ['name' => 'Rahul Varma', 'role' => 'Café & Snacks Lead', 'bio' => 'Keeps bun maska, puffs, and evening bites fresh for travelers and local families.', 'image' => 'https://images.unsplash.com/photo-1607990283143-e81e7a2c93ab?q=80&w=400&auto=format&fit=crop', 'sort_order' => 3],
        ];

        foreach ($members as $member) {
            TeamMember::firstOrCreate(['name' => $member['name']], $member);
        }
    }

    protected function seedOffers(): void
    {
        $offers = [
            ['badge' => 'MORNING CHAI', 'title' => 'Sunrise Masala Combo', 'description' => 'Karivepaku chai with bun maska and filter coffee shot.', 'price' => 149, 'compare_price' => 199, 'icon_classes' => 'fa-mug-hot fa-cookie', 'button_link' => '/products?category=premium-coffees', 'sort_order' => 1],
            ['badge' => 'EVENING SPECIAL', 'title' => 'Ginger Chai & Snacks', 'description' => 'Strong ginger tea with hot puffs and garlic toast.', 'price' => 179, 'compare_price' => 229, 'icon_classes' => 'fa-mug-hot fa-fire', 'button_link' => '/products?category=hot-items', 'sort_order' => 2],
            ['badge' => 'COOLER PAIR', 'title' => 'Iced Tea & Bites', 'description' => 'Mint cooler with light sweets from our tea-time menu.', 'price' => 199, 'compare_price' => 259, 'icon_classes' => 'fa-glass-water fa-leaf', 'button_link' => '/products?category=mocktails', 'sort_order' => 3],
        ];

        foreach ($offers as $offer) {
            HomepageOffer::firstOrCreate(['title' => $offer['title']], $offer);
        }
    }

    protected function seedPageContent(): void
    {
        PageContent::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'Our Tea Journey',
                'body' => 'Mana Ooru Mana Tea began at a highway tea point on NH 216 in Arumbaka — brewing honest chai for travelers, locals, and families since day one.',
                'meta' => [
                    'established' => '2018',
                    'headline' => 'Where Every Cup Tells a Story',
                    'subtitle' => 'South Indian chai, filter coffee & café warmth',
                    'hero_image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=800&auto=format&fit=crop',
                    'story_paragraphs' => [
                        'Mana Ooru Mana Tea serves fresh masala chai, karivepaku tea, ginger brews, and strong filter coffee beside NH 216 at Arumbaka, Guntur. Our lounge is a pause worth taking — warm snacks, cold drinks, and smiles with every pour.',
                        'We source quality tea leaves and coffee beans, brew in small batches, and pair every cup with bun maska, puffs, and light bites. Whether you are fueling up or winding down, our team pours with care.',
                    ],
                    'values' => [
                        ['icon' => 'fa-mug-hot', 'title' => 'Fresh Brews Daily', 'description' => 'Chai and coffee made to order — never sitting too long on the burner.'],
                        ['icon' => 'fa-leaf', 'title' => 'Authentic Flavors', 'description' => 'Classic South Indian recipes with the right spice, strength, and warmth.'],
                        ['icon' => 'fa-heart', 'title' => 'Highway Hospitality', 'description' => 'Open hearts, quick service, and a clean stop for every journey.'],
                    ],
                    'timeline' => [
                        ['year' => '2018', 'title' => 'First Kettle', 'description' => 'Started serving chai and snacks to NH 216 travelers.', 'icon' => 'fa-seedling', 'side' => 'left'],
                        ['year' => '2020', 'title' => 'Tea Lounge Opens', 'description' => 'Expanded menu with filter coffee, mocktails, and evening bites.', 'icon' => 'fa-store', 'side' => 'right'],
                        ['year' => '2023', 'title' => 'Local Favorite', 'description' => 'Became a trusted stop for families and fleet drivers in Guntur district.', 'icon' => 'fa-trophy', 'side' => 'left'],
                        ['year' => '2026', 'title' => 'Digital Menu', 'description' => 'Online ordering, loyalty perks, and full menu at your fingertips.', 'icon' => 'fa-laptop', 'side' => 'right'],
                    ],
                ],
            ]
        );
    }

    protected function seedCustomCakeOptions(): void
    {
        $options = [
            ['group' => 'cake_type', 'label' => 'Morning Chai Combo', 'value' => 'Morning', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'cake_type', 'label' => 'Evening Tea Special (+₹50)', 'value' => 'Evening', 'price_addon' => 50, 'sort_order' => 2],
            ['group' => 'cake_type', 'label' => 'Family Gathering Tray (+₹150)', 'value' => 'Family', 'price_addon' => 150, 'sort_order' => 3],
            ['group' => 'size', 'label' => 'Single Cup — Base ₹99', 'value' => 'Single', 'price_addon' => 99, 'sort_order' => 1],
            ['group' => 'size', 'label' => 'Duo Pair — Base ₹179', 'value' => 'Duo', 'price_addon' => 179, 'sort_order' => 2],
            ['group' => 'size', 'label' => 'Family Tray — Base ₹349', 'value' => 'Family', 'price_addon' => 349, 'sort_order' => 3],
            ['group' => 'shape', 'label' => 'Masala Chai', 'value' => 'Masala Chai', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'shape', 'label' => 'Karivepaku Tea (+₹20)', 'value' => 'Karivepaku Tea', 'price_addon' => 20, 'sort_order' => 2],
            ['group' => 'shape', 'label' => 'Ginger Chai (+₹15)', 'value' => 'Ginger Chai', 'price_addon' => 15, 'sort_order' => 3],
            ['group' => 'shape', 'label' => 'Filter Coffee (+₹25)', 'value' => 'Filter Coffee', 'price_addon' => 25, 'sort_order' => 4],
            ['group' => 'flavor', 'label' => 'Bun Maska', 'value' => 'Bun Maska', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'flavor', 'label' => 'Hot Puff (+₹30)', 'value' => 'Hot Puff', 'price_addon' => 30, 'sort_order' => 2],
            ['group' => 'flavor', 'label' => 'Biscuit Pack (+₹25)', 'value' => 'Biscuit Pack', 'price_addon' => 25, 'sort_order' => 3],
            ['group' => 'flavor', 'label' => 'No snack', 'value' => 'None', 'price_addon' => 0, 'sort_order' => 4],
            ['group' => 'filling', 'label' => 'No extra drink', 'value' => 'None', 'price_addon' => 0, 'sort_order' => 1],
            ['group' => 'filling', 'label' => 'Mint Cooler (+₹40)', 'value' => 'Mint Cooler', 'price_addon' => 40, 'sort_order' => 2],
            ['group' => 'filling', 'label' => 'Chilled Soda (+₹35)', 'value' => 'Chilled Soda', 'price_addon' => 35, 'sort_order' => 3],
        ];

        foreach ($options as $opt) {
            CustomCakeOption::firstOrCreate(
                ['group' => $opt['group'], 'value' => $opt['value']],
                $opt
            );
        }
    }
}
