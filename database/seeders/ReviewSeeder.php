<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::query()->delete();

        $reviewers = [
            ['name' => 'Ravi Kumar', 'email' => 'ravi.kumar@example.com'],
            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@example.com'],
            ['name' => 'Arjun Reddy', 'email' => 'arjun.reddy@example.com'],
            ['name' => 'Lakshmi Devi', 'email' => 'lakshmi.devi@example.com'],
            ['name' => 'Vikram Naidu', 'email' => 'vikram.naidu@example.com'],
            ['name' => 'Anitha Rao', 'email' => 'anitha.rao@example.com'],
        ];

        $userIds = [];
        foreach ($reviewers as $i => $reviewer) {
            $user = User::updateOrCreate(
                ['email' => $reviewer['email']],
                [
                    'name' => $reviewer['name'],
                    'password' => Hash::make('password'),
                    'phone' => '900000000' . $i,
                    'role' => 'user',
                    'loyalty_points' => 50 + ($i * 10),
                    'address' => 'Guntur District, Andhra Pradesh',
                ]
            );
            $userIds[] = $user->id;
        }

        $products = Product::active()
            ->where(function ($q) {
                $q->featured()->orWhere('is_bestseller', true);
            })
            ->orderBy('id')
            ->take(6)
            ->get();

        if ($products->isEmpty()) {
            $products = Product::active()->orderBy('id')->take(6)->get();
        }

        if ($products->isEmpty()) {
            return;
        }

        $reviews = [
            ['rating' => 5, 'comment' => 'The masala chai here is perfectly spiced — strong, creamy, and fresh every time. Best stop on NH 216.'],
            ['rating' => 5, 'comment' => 'Karivepaku tea with bun maska is my evening ritual. Crisp leaves, soft bun, and quick service.'],
            ['rating' => 5, 'comment' => 'Filter coffee foam and aroma remind me of home. Paired with hot puffs — unbeatable combo.'],
            ['rating' => 4, 'comment' => 'Ginger chai hits the right heat level. Great for long drives; snacks stay warm and fresh.'],
            ['rating' => 5, 'comment' => 'Mint cooler was refreshing after a sunny drive. Clean lounge, friendly team, fair prices.'],
            ['rating' => 5, 'comment' => 'Ordered the sunrise combo — chai, bun maska, and coffee shot. Everything tasted made-to-order.'],
        ];

        foreach ($products as $index => $product) {
            $data = $reviews[$index % count($reviews)];
            Review::create([
                'user_id' => $userIds[$index % count($userIds)],
                'product_id' => $product->id,
                'rating' => $data['rating'],
                'comment' => $data['comment'],
                'is_approved' => true,
                'is_verified_purchase' => true,
            ]);
        }
    }
}
