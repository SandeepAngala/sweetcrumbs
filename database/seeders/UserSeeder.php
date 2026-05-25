<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@manaoorumanatea.com'],
            [
                'name' => 'Sandeep Angala',
                'password' => Hash::make('password'),
                'phone' => '1234567890',
                'avatar' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=400&auto=format&fit=crop',
                'role' => 'admin',
                'loyalty_points' => 500,
                'address' => 'Arumbaka, NH 216, Guntur - 522309',
            ]
        );

        // Create Regular Customer
        User::updateOrCreate(
            ['email' => 'user@manaoorumanatea.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'phone' => '9876543210',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=400&auto=format&fit=crop',
                'role' => 'user',
                'loyalty_points' => 120,
                'address' => 'Bapatla, Guntur District',
            ]
        );
    }
}
