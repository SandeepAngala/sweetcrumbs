<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['category', 'reviews']);

        // Live Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ingredients', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $categorySlugs = (array) $request->input('category');
            $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id');
            $query->whereIn('category_id', $categoryIds);
        }

        // Price Filter
        if ($request->filled('price_min')) {
            $query->where(function($q) use ($request) {
                $q->where('discount_price', '>=', $request->input('price_min'))
                  ->orWhere(function($sq) use ($request) {
                      $sq->whereNull('discount_price')
                         ->where('price', '>=', $request->input('price_min'));
                  });
            });
        }
        if ($request->filled('price_max')) {
            $query->where(function($q) use ($request) {
                $q->where('discount_price', '<=', $request->input('price_max'))
                  ->orWhere(function($sq) use ($request) {
                      $sq->whereNull('discount_price')
                         ->where('price', '<=', $request->input('price_max'));
                  });
            });
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('discount_price', 'asc')->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('discount_price', 'desc')->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'featured':
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::active()
            ->with(['category', 'reviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->with(['category', 'reviews'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->with('user')->orderBy('created_at', 'desc')->get();

        return view('products.show', compact('product', 'relatedProducts', 'reviews'));
    }

    public function search(Request $request)
    {
        $search = $request->input('query');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->where('name', 'like', "%{$search}%")
            ->select('id', 'name', 'slug', 'price', 'discount_price', 'images')
            ->take(5)
            ->get();

        $formatted = $products->map(function($product) {
            return [
                'name' => $product->name,
                'url' => route('products.show', $product->slug),
                'price' => $product->discount_price ?: $product->price,
                'image' => $product->primary_image
            ];
        });

        return response()->json($formatted);
    }

    public function storeReview(Request $request, $slug)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $product = Product::active()->where('slug', $slug)->firstOrFail();

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true // Auto approved for instant demo feedback
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
