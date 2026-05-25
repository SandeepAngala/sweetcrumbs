<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CustomCakeOption;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

/**
 * Safe production refresh: tea content, images, reviews, blogs, combo builder.
 */
class ContentRefreshSeeder extends Seeder
{
    public function run(): void
    {
        $this->fixCategoryImages();
        $this->fixSoftDrinkImages();
        $this->refreshGalleryAndTeam();
        $this->refreshFaqs();
        $this->refreshTeaComboOptions();

        $this->call([
            BlogSeeder::class,
            ReviewSeeder::class,
        ]);

        foreach ([
            'home_banners', 'home_categories', 'home_hot_selling', 'home_trending_desserts',
            'home_mocktails', 'home_coffee', 'home_ice_creams', 'home_chef_picks',
            'home_bestsellers', 'home_testimonials', 'home_blogs', 'home_offers',
        ] as $key) {
            Cache::forget($key);
        }

        try {
            Artisan::call('view:clear');
        } catch (\Throwable) {
            // ignore when running without full app bootstrap
        }
    }

    protected function fixCategoryImages(): void
    {
        $images = [
            'hot-items' => 'https://images.unsplash.com/photo-1563822249361-3b327edf2d3d?q=80&w=800&auto=format&fit=crop',
            'mocktails' => 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=800&auto=format&fit=crop',
        ];

        foreach ($images as $slug => $url) {
            Category::where('slug', $slug)->update(['image' => $url]);
        }
    }

    protected function fixSoftDrinkImages(): void
    {
        $map = [
            'Sprite' => 'https://images.unsplash.com/photo-1613479172729-b49209d96646?q=80&w=600&auto=format&fit=crop',
            'Fanta' => 'https://images.unsplash.com/photo-1600274640238-0125ef5d0b4f?q=80&w=600&auto=format&fit=crop',
            'Pepsi' => 'https://images.unsplash.com/photo-1629203851122-3726ecdf080e?q=80&w=600&auto=format&fit=crop',
            'Coca-Cola' => 'https://images.unsplash.com/photo-1629203851122-3726ecdf080e?q=80&w=600&auto=format&fit=crop',
        ];

        foreach ($map as $name => $url) {
            Product::where('name', $name)->update(['images' => [$url]]);
        }
    }

    protected function refreshGalleryAndTeam(): void
    {
        GalleryItem::query()->delete();

        $items = [
            ['title' => 'Masala Chai at Sunrise', 'description' => 'Fresh kadai brew with cardamom and ginger.', 'image' => 'https://images.unsplash.com/photo-1571934811356-798df2168c42?q=80&w=600', 'category' => 'chai', 'sort_order' => 1],
            ['title' => 'Bun Maska & Filter Coffee', 'description' => 'Classic highway tea-time pairing.', 'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=600', 'category' => 'café', 'sort_order' => 2],
            ['title' => 'Evening Ginger Chai', 'description' => 'Bold ginger boil served with hot puffs.', 'image' => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?q=80&w=600', 'category' => 'evening', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            GalleryItem::create($item);
        }

        TeamMember::query()->delete();

        $members = [
            ['name' => 'Sandeep Angala', 'role' => 'Founder & Tea Master', 'bio' => 'Built Mana Ooru Mana Tea on NH 216 with honest chai, filter coffee, and warm highway hospitality.', 'image' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=400&auto=format&fit=crop', 'sort_order' => 1],
            ['name' => 'Kavya Menon', 'role' => 'Head Chai Brewer', 'bio' => 'Expert in masala, karivepaku, and ginger chai — every cup balanced for strength and aroma.', 'image' => 'https://images.unsplash.com/photo-1581299894007-aaa50297cf16?q=80&w=400&auto=format&fit=crop', 'sort_order' => 2],
            ['name' => 'Rahul Varma', 'role' => 'Café & Snacks Lead', 'bio' => 'Keeps bun maska, puffs, and evening bites fresh for travelers and local families.', 'image' => 'https://images.unsplash.com/photo-1607990283143-e81e7a2c93ab?q=80&w=400&auto=format&fit=crop', 'sort_order' => 3],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }

    protected function refreshFaqs(): void
    {
        Faq::where('question', 'like', '%custom cake%')->orWhere('question', 'like', '%eggless%')->delete();

        $faqs = [
            ['category' => 'orders', 'question' => 'How far do you deliver from Arumbaka?', 'answer' => 'We deliver within 15 km of our NH 216 tea lounge. Orders above the free delivery threshold qualify for complimentary delivery.', 'sort_order' => 1],
            ['category' => 'products', 'question' => 'Can I customize a tea combo?', 'answer' => 'Yes — use Tea Bar to pick your chai style, snack, serving size, and optional cooler. Submit the form and our team confirms pricing.', 'sort_order' => 3],
            ['category' => 'custom', 'question' => 'How early should I book a large combo tray?', 'answer' => 'For family trays or event combos, please request at least 24 hours ahead so we can prepare fresh brews and snacks.', 'sort_order' => 4],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }

    protected function refreshTeaComboOptions(): void
    {
        CustomCakeOption::query()->delete();

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
            CustomCakeOption::create($opt);
        }
    }
}
