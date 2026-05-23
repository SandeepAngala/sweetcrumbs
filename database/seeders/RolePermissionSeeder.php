<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Manage Products', 'slug' => 'manage-products', 'group' => 'catalog'],
            ['name' => 'Manage Categories', 'slug' => 'manage-categories', 'group' => 'catalog'],
            ['name' => 'Manage Orders', 'slug' => 'manage-orders', 'group' => 'orders'],
            ['name' => 'Manage Customers', 'slug' => 'manage-customers', 'group' => 'users'],
            ['name' => 'Manage Coupons', 'slug' => 'manage-coupons', 'group' => 'marketing'],
            ['name' => 'View Analytics', 'slug' => 'view-analytics', 'group' => 'reports'],
            ['name' => 'Manage Inventory', 'slug' => 'manage-inventory', 'group' => 'inventory'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'group' => 'system'],
            ['name' => 'Manage Reviews', 'slug' => 'manage-reviews', 'group' => 'catalog'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $roles = [
            'super_admin' => Permission::pluck('id'),
            'admin' => Permission::whereIn('slug', [
                'manage-products', 'manage-categories', 'manage-orders',
                'manage-customers', 'manage-coupons', 'view-analytics',
                'manage-inventory', 'manage-reviews',
            ])->pluck('id'),
            'staff' => Permission::whereIn('slug', [
                'manage-orders', 'manage-inventory', 'view-analytics',
            ])->pluck('id'),
            'customer' => collect(),
        ];

        foreach ($roles as $slug => $permissionIds) {
            $role = Role::firstOrCreate(
                ['slug' => $slug],
                ['name' => ucfirst(str_replace('_', ' ', $slug))]
            );
            $role->permissions()->sync($permissionIds);
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sweetcrumbs.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->roles()->sync([Role::where('slug', 'super_admin')->first()->id]);

        $staff = User::firstOrCreate(
            ['email' => 'staff@sweetcrumbs.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
        $staff->roles()->sync([Role::where('slug', 'staff')->first()->id]);
    }
}
