<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product.category')->get();
        return view('wishlist', compact('wishlistItems'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id'
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;

        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($exists) {
            $exists->delete();
            $status = 'removed';
            $message = 'Item successfully removed from wishlist!';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $status = 'added';
            $message = 'Item successfully added to wishlist!';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message
        ]);
    }

    public function moveToCart(Request $request, CartService $cartService, $productId)
    {
        try {
            $userId = auth()->id();
            
            // Add to active cart
            $cartService->addToCart($userId, $productId, 1);
            
            // Remove from wishlist
            Wishlist::where('user_id', $userId)->where('product_id', $productId)->delete();

            return redirect()->route('cart.index')->with('success', 'Item successfully moved to cart!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
