<?php

namespace App\Providers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Helpers\BakerySettings;
use App\Listeners\MergeGuestCartOnLogin;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\HomepageOffer;
use App\Models\PageContent;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Wishlist;
use App\Observers\ClearsHomeCacheObserver;
use App\Services\CartService;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('forms', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip());
        });

        Gate::before(function ($user, $ability) {
            if ($user?->role === 'super_admin' || $user?->hasRole('super_admin')) {
                return true;
            }
        });

        Event::listen(Login::class, MergeGuestCartOnLogin::class);

        $cacheObserver = ClearsHomeCacheObserver::class;
        foreach ([Product::class, Banner::class, Category::class, HomepageOffer::class, Review::class, Blog::class, Faq::class, GalleryItem::class, TeamMember::class, PageContent::class] as $model) {
            $model::observe($cacheObserver);
        }
        Setting::saved(fn () => BakerySettings::clearCache());

        View::composer(['components.product-card', 'products.index', 'products.show', 'home', 'wishlist'], function ($view) {
            $view->with('wishlistProductIds', auth()->check()
                ? Wishlist::where('user_id', auth()->id())->pluck('product_id')->flip()
                : collect());
        });

        View::composer(['components.navbar', 'layouts.app', 'components.footer', 'contact', 'faq', 'checkout.index', 'cart.index', 'home', 'gallery', 'about', 'testimonials', 'custom-cake'], function ($view) {
            $cartService = app(CartService::class);
            $view->with([
                'navbarCartCount' => $cartService->getCartCount(auth()->id()),
                'bakery' => BakerySettings::all(),
            ]);
        });
    }
}
