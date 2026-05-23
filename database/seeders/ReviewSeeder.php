<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('role', 'user')->first();
        $customerId = $customer ? $customer->id : 2;

        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'This is hands down the best red velvet cake I have ever had! The raspberry coulis cuts through the sweetness perfectly. Incredible quality.',
                'is_approved' => true,
            ],
            [
                'rating' => 5,
                'comment' => 'Absolutely buttery and flaky. Tastes exactly like the ones I had in Paris. Will order again!',
                'is_approved' => true,
            ],
            [
                'rating' => 4,
                'comment' => 'Very rich and chocolatey. A bit heavy, but highly delicious. Recommended for true chocolate lovers.',
                'is_approved' => true,
            ],
            [
                'rating' => 5,
                'comment' => 'Amazing sourdough bread! The crumb is so airy and the crust is perfectly crispy. Wonderful tang!',
                'is_approved' => true,
            ],
        ];

        // Seed reviews for some products
        foreach ($products as $index => $product) {
            $reviewData = $reviews[$index % count($reviews)];
            Review::create([
                'user_id' => $customerId,
                'product_id' => $product->id,
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'],
                'is_approved' => $reviewData['is_approved'],
            ]);
        }
    }
}
