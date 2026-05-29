<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->middleware('throttle:forms')->name('contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::post('/testimonials', [PageController::class, 'storeTestimonial'])->middleware('auth')->name('testimonials.store');
Route::get('/custom-cake', [PageController::class, 'customCake'])->name('custom-cake');
Route::post('/custom-cake', [PageController::class, 'customCakeStore'])->middleware('throttle:forms')->name('custom-cake.store');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->middleware('throttle:forms')->name('newsletter.subscribe');

// Guest-friendly cart add (session cart)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::post('/cart/save-for-later/{productId}', [CartController::class, 'saveForLater'])->name('cart.save-for-later');
    Route::post('/cart/move-to-cart/{productId}', [CartController::class, 'moveToCart'])->name('cart.move-to-cart');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/wishlist/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/api/create-order', [App\Http\Controllers\RazorpayController::class, 'createOrder'])->name('checkout.razorpay.create');
    Route::post('/api/verify-payment', [App\Http\Controllers\RazorpayController::class, 'verifyPayment'])->name('checkout.razorpay.verify');

    // User Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/home', [DashboardController::class, 'index'])->name('index');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [DashboardController::class, 'orderDetail'])->name('orders.show');
        Route::get('/addresses', [DashboardController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [DashboardController::class, 'storeAddress'])->name('addresses.store');
        Route::put('/addresses/{id}', [DashboardController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{id}', [DashboardController::class, 'deleteAddress'])->name('addresses.destroy');
        Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/{id}/read', [DashboardController::class, 'markNotificationRead'])->name('notifications.read');
    });

    // Review Submission
    Route::post('/products/{slug}/review', [ProductController::class, 'storeReview'])->name('products.review');

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FIX 7: Razorpay server-to-server webhook (no auth, no CSRF — handled by HMAC signature verification)
Route::post('razorpay/webhook', [App\Http\Controllers\RazorpayController::class, 'webhook'])->name('razorpay.webhook');

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
