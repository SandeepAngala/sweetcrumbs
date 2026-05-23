<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::middleware('throttle:auth')->group(function () {
        Route::post('/auth/register', [AuthController::class, 'register']);
        Route::post('/auth/login', [AuthController::class, 'login']);
    });

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/products/{slug}/reviews', [ProductController::class, 'reviews']);

    Route::get('/cms/settings', [App\Http\Controllers\Api\CmsController::class, 'settings']);
    Route::get('/cms/faqs', [App\Http\Controllers\Api\CmsController::class, 'faqs']);
    Route::get('/cms/gallery', [App\Http\Controllers\Api\CmsController::class, 'gallery']);
    Route::get('/cms/offers', [App\Http\Controllers\Api\CmsController::class, 'offers']);
    Route::get('/cms/banners', [App\Http\Controllers\Api\CmsController::class, 'banners']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    Route::post('/payments/webhook/{provider}', [PaymentController::class, 'webhook']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::put('/cart', [CartController::class, 'update']);
        Route::delete('/cart/{productId}', [CartController::class, 'destroy']);
        Route::post('/cart/coupon', [CartController::class, 'applyCoupon']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
        Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel']);
        Route::get('/orders/{orderNumber}/track', [OrderController::class, 'track']);

        Route::post('/payments/intent/{orderNumber}', [PaymentController::class, 'createIntent']);
        Route::post('/payments/verify', [PaymentController::class, 'verify']);

        Route::post('/products/{slug}/reviews', [ReviewController::class, 'store']);

        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    });

    Route::middleware(['auth:sanctum', 'role:admin|super_admin|staff'])->prefix('admin')->group(function () {
        Route::get('/analytics', [AnalyticsController::class, 'index']);
        Route::get('/analytics/charts', [AnalyticsController::class, 'charts']);

        Route::get('/inventory', [InventoryController::class, 'index']);
        Route::post('/inventory/{product}/adjust', [InventoryController::class, 'adjust']);

        Route::get('/settings', [SettingsController::class, 'index']);
        Route::put('/settings', [SettingsController::class, 'update']);
    });
});
