<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/data', [AnalyticsController::class, 'charts'])->name('analytics.charts');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/tracking', [OrderController::class, 'addTracking'])->name('orders.tracking');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers/{id}/block', [CustomerController::class, 'block'])->name('customers.block');
    Route::post('/customers/{id}/unblock', [CustomerController::class, 'unblock'])->name('customers.unblock');
    Route::get('/customers/export/csv', [CustomerController::class, 'export'])->name('customers.export');

    Route::resource('coupons', CouponController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('banners', BannerController::class);

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::delete('/reviews/{id}', [ReviewController::class, 'reject'])->name('reviews.reject');

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class)->except(['show']);
    Route::resource('gallery', App\Http\Controllers\Admin\GalleryItemController::class)->except(['show']);
    Route::resource('offers', App\Http\Controllers\Admin\HomepageOfferController::class)->except(['show']);
    Route::resource('team', App\Http\Controllers\Admin\TeamMemberController::class)->except(['show']);
});
