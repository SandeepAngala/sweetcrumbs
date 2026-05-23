<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'store_name', 'value' => 'Sweet Crumbs', 'group' => 'general'],
            ['key' => 'store_email', 'value' => 'hello@sweetcrumbs.com', 'group' => 'general'],
            ['key' => 'store_phone', 'value' => '+91 98765 43210', 'group' => 'general'],
            ['key' => 'tax_rate', 'value' => '0.05', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'free_delivery_threshold', 'value' => '500', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'delivery_charge', 'value' => '50', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'upi_id', 'value' => 'sweetcrumbs@upi', 'group' => 'payments'],
        ];

        foreach ($defaults as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
