<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10.00,
                'min_order_amount' => 300.00,
                'max_discount' => 150.00,
                'usage_limit' => 500,
                'used_count' => 0,
                'starts_at' => Carbon::now()->subDay(),
                'expires_at' => Carbon::now()->addYear(),
                'is_active' => true,
            ],
            [
                'code' => 'SWEET20',
                'type' => 'percent',
                'value' => 20.00,
                'min_order_amount' => 1000.00,
                'max_discount' => 500.00,
                'usage_limit' => 200,
                'used_count' => 0,
                'starts_at' => Carbon::now()->subDay(),
                'expires_at' => Carbon::now()->addYear(),
                'is_active' => true,
            ],
            [
                'code' => 'FLAT100',
                'type' => 'fixed',
                'value' => 100.00,
                'min_order_amount' => 600.00,
                'max_discount' => 100.00,
                'usage_limit' => 100,
                'used_count' => 0,
                'starts_at' => Carbon::now()->subDay(),
                'expires_at' => Carbon::now()->addYear(),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coup) {
            Coupon::updateOrCreate(
                ['code' => $coup['code']],
                $coup
            );
        }
    }
}
