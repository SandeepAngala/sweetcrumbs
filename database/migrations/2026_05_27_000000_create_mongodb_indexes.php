<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';

    public function up(): void
    {
        // Users indexes
        Schema::connection('mongodb')->table('users', function (Blueprint $collection) {
            $collection->index('email');
            $collection->index('uuid');
            $collection->index('role');
            $collection->index('google_id');
        });

        // Products indexes
        Schema::connection('mongodb')->table('products', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('category_id');
            $collection->index('status');
            $collection->index('sku');
            $collection->index('is_featured');
            $collection->index('is_trending');
            $collection->index('is_bestseller');
        });

        // Categories indexes
        Schema::connection('mongodb')->table('categories', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('parent_id');
            $collection->index('is_active');
        });

        // Orders indexes
        Schema::connection('mongodb')->table('orders', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('order_number');
            $collection->index('status');
            $collection->index('payment_status');
            $collection->index('created_at');
        });

        // Order items indexes
        Schema::connection('mongodb')->table('order_items', function (Blueprint $collection) {
            $collection->index('order_id');
            $collection->index('product_id');
        });

        // Carts indexes
        Schema::connection('mongodb')->table('carts', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('product_id');
            $collection->compound(['user_id', 'product_id']);
        });

        // Payments indexes
        Schema::connection('mongodb')->table('payments', function (Blueprint $collection) {
            $collection->index('order_id');
            $collection->index('transaction_id');
        });

        // Reviews indexes
        Schema::connection('mongodb')->table('reviews', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('product_id');
            $collection->index('is_approved');
        });

        // Wishlists indexes
        Schema::connection('mongodb')->table('wishlists', function (Blueprint $collection) {
            $collection->compound(['user_id', 'product_id']);
        });

        // Coupons indexes
        Schema::connection('mongodb')->table('coupons', function (Blueprint $collection) {
            $collection->index('code');
            $collection->index('is_active');
        });

        // Blogs indexes
        Schema::connection('mongodb')->table('blogs', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('is_published');
        });

        // Settings indexes
        Schema::connection('mongodb')->table('settings', function (Blueprint $collection) {
            $collection->index('key');
        });

        // Addresses indexes
        Schema::connection('mongodb')->table('addresses', function (Blueprint $collection) {
            $collection->index('user_id');
        });

        // Bakery notifications indexes
        Schema::connection('mongodb')->table('bakery_notifications', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('read_at');
        });

        // Delivery trackings indexes
        Schema::connection('mongodb')->table('delivery_trackings', function (Blueprint $collection) {
            $collection->index('order_id');
        });

        // Inventory logs indexes
        Schema::connection('mongodb')->table('inventory_logs', function (Blueprint $collection) {
            $collection->index('product_id');
        });

        // Coupon usages indexes
        Schema::connection('mongodb')->table('coupon_usages', function (Blueprint $collection) {
            $collection->index('coupon_id');
            $collection->index('user_id');
            $collection->index('order_id');
        });

        // Page contents indexes
        Schema::connection('mongodb')->table('page_contents', function (Blueprint $collection) {
            $collection->index('slug');
        });
    }

    public function down(): void
    {
        // MongoDB will drop indexes when collections are dropped
    }
};
