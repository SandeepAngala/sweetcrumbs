<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    protected function userId(): ?int
    {
        return auth()->id();
    }

    public function index()
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('warning', 'Please log in to view your cart.');
        }

        $userId = $this->userId();
        $cartItems = $this->cartService->getCart($userId);
        $savedItems = $this->cartService->getSavedForLater($userId);
        $totals = $this->cartService->calculateTotals($userId);
        $couponCode = session('coupon_code', '');

        return view('cart.index', compact('cartItems', 'savedItems', 'totals', 'couponCode'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        try {
            $quantity = (int) ($request->quantity ?? 1);
            $this->cartService->addToCart($this->userId(), $request->product_id, $quantity);
            $count = $this->cartService->getCartCount($this->userId());

            return response()->json([
                'success' => true,
                'message' => 'Product successfully added to cart!',
                'cart_count' => $count,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id',
            'quantity' => 'required|integer|min:0',
        ]);

        if (! auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Please log in to update your cart.'], 401);
        }

        try {
            $userId = $this->userId();
            $this->cartService->updateQuantity($userId, $request->product_id, $request->quantity);
            session()->forget(['coupon_code', 'coupon_discount']);

            return response()->json([
                'success' => true,
                'message' => 'Cart successfully updated!',
                'item_qty' => $request->quantity,
                'totals' => $this->cartService->calculateTotals($userId, 0),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,_id',
        ]);

        if (! auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Please log in.'], 401);
        }

        $this->cartService->removeFromCart($this->userId(), $request->product_id);
        session()->forget(['coupon_code', 'coupon_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Item successfully removed from cart!',
            'totals' => $this->cartService->calculateTotals($this->userId(), 0),
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        if (! auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Please log in to apply a coupon.'], 401);
        }

        try {
            $userId = $this->userId();
            $subtotal = $this->cartService->getCartTotal($userId);
            $couponData = $this->cartService->applyCoupon($request->code, $subtotal);

            session([
                'coupon_code' => $couponData['coupon']->code,
                'coupon_discount' => $couponData['discount'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coupon code applied successfully!',
                'discount' => $couponData['discount'],
                'totals' => $this->cartService->calculateTotals($userId, $couponData['discount']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function saveForLater($productId)
    {
        try {
            $this->cartService->saveForLater($this->userId(), (int) $productId);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Item list preference successfully changed.');
    }

    public function moveToCart($productId)
    {
        $this->cartService->saveForLater($this->userId(), (int) $productId);

        return back()->with('success', 'Item successfully returned to active cart.');
    }
}
