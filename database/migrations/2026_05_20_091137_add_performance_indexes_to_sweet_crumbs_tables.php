<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('is_featured');
            $table->index('is_trending');
            $table->index('is_bestseller');
            $table->index('status');
            $table->index('category_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('sort_order');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index('is_approved');
            $table->index('product_id');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->index('is_published');
            $table->index('category');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_trending']);
            $table->dropIndex(['is_bestseller']);
            $table->dropIndex(['status']);
            $table->dropIndex(['category_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['is_approved']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['category']);
            $table->dropIndex(['published_at']);
        });
    }
};
