<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with('products')->orderBy('sort_order', 'asc')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(\Illuminate\Http\Request $request, $slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();
        
        $query = Product::active()->with('category')->where('category_id', $category->id);

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

        return view('categories.show', compact('category', 'products'));
    }
}
