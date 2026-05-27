<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mongodb';

    /**
     * Safely create an index, ignoring "already exists" errors from MongoDB.
     */
    private function safeIndex(string $collection, \Closure $callback): void
    {
        try {
            Schema::connection('mongodb')->table($collection, $callback);
        } catch (\Exception $e) {
            if (!str_contains($e->getMessage(), 'already exists')
                && !str_contains($e->getMessage(), 'same name as the requested index')) {
                throw $e;
            }
        }
    }

    public function up(): void
    {
        // Users indexes
        $this->safeIndex('users', function (Blueprint $collection) {
            $collection->index('email');
            $collection->index('uuid');
            $collection->index('role');
            $collection->index('google_id');
        });

        // Products indexes
        $this->safeIndex('products', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('category_id');
            $collection->index('status');
            $collection->index('sku');
            $collection->index('is_featured');
            $collection->index('is_trending');
            $collection->index('is_bestseller');
        });

        // Categories indexes
        $this->safeIndex('categories', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('parent_id');
            $collection->index('is_active');
        });

        // Orders indexes
        $this->safeIndex('orders', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('order_number');
            $collection->index('status');
            $collection->index('payment_status');
            $collection->index('created_at');
        });

        // Order items indexes
        $this->safeIndex('order_items', function (Blueprint $collection) {
            $collection->index('order_id');
            $collection->index('product_id');
        });

        // Carts indexes
        $this->safeIndex('carts', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('product_id');
            $collection->compound(['user_id', 'product_id']);
        });

        // Payments indexes
        $this->safeIndex('payments', function (Blueprint $collection) {
            $collection->index('order_id');
            $collection->index('transaction_id');
        });

        // Reviews indexes
        $this->safeIndex('reviews', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('product_id');
            $collection->index('is_approved');
        });

        // Wishlists indexes
        $this->safeIndex('wishlists', function (Blueprint $collection) {
            $collection->compound(['user_id', 'product_id']);
        });

        // Coupons indexes
        $this->safeIndex('coupons', function (Blueprint $collection) {
            $collection->index('code');
            $collection->index('is_active');
        });

        // Blogs indexes
        $this->safeIndex('blogs', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('is_published');
        });

        // Settings indexes
        $this->safeIndex('settings', function (Blueprint $collection) {
            $collection->index('key');
        });

        // Addresses indexes
        $this->safeIndex('addresses', function (Blueprint $collection) {
            $collection->index('user_id');
        });

        // Bakery notifications indexes
        $this->safeIndex('bakery_notifications', function (Blueprint $collection) {
            $collection->index('user_id');
            $collection->index('read_at');
        });

        // Delivery trackings indexes
        $this->safeIndex('delivery_trackings', function (Blueprint $collection) {
            $collection->index('order_id');
        });

        // Inventory logs indexes
        $this->safeIndex('inventory_logs', function (Blueprint $collection) {
            $collection->index('product_id');
        });

        // Coupon usages indexes
        $this->safeIndex('coupon_usages', function (Blueprint $collection) {
            $collection->index('coupon_id');
            $collection->index('user_id');
            $collection->index('order_id');
        });

        // Page contents indexes
        $this->safeIndex('page_contents', function (Blueprint $collection) {
            $collection->index('slug');
        });
    }

    public function down(): void
    {
        // MongoDB will drop indexes when collections are dropped
    }
};
