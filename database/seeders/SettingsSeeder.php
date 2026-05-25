<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'store_name', 'value' => 'Mana Ooru Mana Tea', 'group' => 'general'],
            ['key' => 'store_email', 'value' => 'hello@manaoorumanatea.com', 'group' => 'general'],
            ['key' => 'store_phone', 'value' => '+91 98765 43210', 'group' => 'general'],
            ['key' => 'store_address', 'value' => 'M/s Sri Sai Hariharan Filling Station, Sy No 419/2, NH 216, Chandolu Cherukupalli Rd, Arumbaka, Bapatla, Guntur - 522309, Andhra Pradesh', 'group' => 'contact'],
            ['key' => 'footer_address', 'value' => 'Arumbaka, Guntur — NH 216 (Mana Ooru Mana Tea @ HP Retail)', 'group' => 'contact'],
            ['key' => 'google_maps_link', 'value' => 'https://share.google/h8dNyeSgTNanDuS2x', 'group' => 'contact'],
            ['key' => 'map_embed_url', 'value' => 'https://www.google.com/maps?q=16.03690084,80.66422922&hl=en&z=16&output=embed', 'group' => 'contact'],
            ['key' => 'tax_rate', 'value' => '0.05', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'free_delivery_threshold', 'value' => '500', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'delivery_charge', 'value' => '50', 'group' => 'checkout', 'type' => 'float'],
            ['key' => 'upi_id', 'value' => 'manaoorumanatea@upi', 'group' => 'payments'],
        ];

        foreach ($defaults as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
