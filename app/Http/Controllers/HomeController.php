<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache categories & banners for 30 minutes (rarely change)
        $banners = Cache::remember('home_banners', 1800, function () {
            return Banner::active()->get();
        });

        $categories = Cache::remember('home_categories', 1800, function () {
            return Category::active()->orderBy('sort_order', 'asc')->get();
        });

        // Cache product collections for 10 minutes with eager loading
        $hotSelling = Cache::remember('home_hot_selling', 600, function () {
            return Product::active()
                ->with('category')
                ->withCount('reviews')
                ->whereHas('category', fn ($q) => $q->where('slug', 'hot-items'))
                ->take(8)
                ->get();
        });

        $trendingDesserts = Cache::remember('home_trending_desserts', 600, function () {
            return Product::active()
                ->with('category')
                ->withCount('reviews')
                ->whereHas('category', fn ($q) => $q->where('slug', 'sweets-desserts'))
                ->trending()
                ->take(8)
                ->get();
        });

        $mocktailSpecials = Cache::remember('home_mocktails', 600, function () {
            return Product::active()
                ->with('category')
                ->withCount('reviews')
                ->whereHas('category', fn ($q) => $q->where('slug', 'mocktails'))
                ->take(8)
                ->get();
        });

        $coffeeCollection = Cache::remember('home_coffee', 600, function () {
            return Product::active()
                ->with('category')
                ->withCount('reviews')
                ->whereHas('category', fn ($q) => $q->where('slug', 'premium-coffees'))
                ->take(8)
                ->get();
        });

        $iceCreams = Cache::remember('home_ice_creams', 600, function () {
            return Product::active()
                ->with('category')
                ->withCount('reviews')
                ->whereHas('category', fn ($q) => $q->where('slug', 'ice-creams'))
                ->take(8)
                ->get();
        });

        $chefRecommendations = Cache::remember('home_chef_picks', 600, function () {
            return Product::active()
                ->featured()
                ->with('category')
                ->withCount('reviews')
                ->take(6)
                ->get();
        });

        $bestsellerProducts = Cache::remember('home_bestsellers', 600, function () {
            return Product::active()
                ->bestseller()
                ->with('category')
                ->withCount('reviews')
                ->take(8)
                ->get();
        });

        $testimonials = Cache::remember('home_testimonials', 600, function () {
            return Review::approved()
                ->with(['user', 'product'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();
        });

        $latestBlogs = Cache::remember('home_blogs', 1800, function () {
            return Blog::published()
                ->with('author')
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        });

        return view('home', compact(
            'banners',
            'categories',
            'hotSelling',
            'trendingDesserts',
            'mocktailSpecials',
            'coffeeCollection',
            'iceCreams',
            'chefRecommendations',
            'bestsellerProducts',
            'testimonials',
            'latestBlogs'
        ));
    }
}
