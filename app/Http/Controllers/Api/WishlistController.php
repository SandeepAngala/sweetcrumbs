<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::whereIn(
            'id',
            Wishlist::where('user_id', $request->user()->id)->pluck('product_id')
        )->with('category')->get();

        return response()->json([
            'data' => ProductResource::collection($products),
            'count' => $products->count(),
        ]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $existing = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
            ]);
            $added = true;
        }

        $count = Wishlist::where('user_id', $request->user()->id)->count();

        return response()->json(['added' => $added, 'count' => $count]);
    }
}
