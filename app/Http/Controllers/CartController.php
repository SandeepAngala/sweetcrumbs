<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart(auth()->id());
        $savedItems = $this->cartService->getSavedForLater(auth()->id());
        $subtotal = $this->cartService->getCartTotal(auth()->id());
        
        $tax = round($subtotal * 0.05, 2); // 5% tax
        $delivery = ($subtotal >= 500 || $subtotal == 0) ? 0.00 : 50.00;
        
        // Retrieve applied coupon from session
        $discount = session('coupon_discount', 0.00);
        $couponCode = session('coupon_code', '');

        $total = ($subtotal + $tax + $delivery) - $discount;
        if ($total < 0) {
            $total = 0.00;
        }

        $totals = [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_charge' => $delivery,
            'discount' => $discount,
            'total' => $total
        ];

        return view('cart.index', compact('cartItems', 'savedItems', 'totals', 'couponCode'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $this->cartService->addToCart(auth()->id(), $request->product_id, $request->quantity);
            $count = $this->cartService->getCartCount(auth()->id());
            
            return response()->json([
                'success' => true,
                'message' => 'Product successfully added to cart!',
                'cart_count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            $userId = auth()->id();
            $this->cartService->updateQuantity($userId, $request->product_id, $request->quantity);
            
            // Clear coupons on update to ensure subtotal remains valid
            session()->forget(['coupon_code', 'coupon_discount']);

            $subtotal = $this->cartService->getCartTotal($userId);
            $tax = round($subtotal * 0.05, 2);
            $delivery = $subtotal >= 500 ? 0.00 : 50.00;
            $total = $subtotal + $tax + $delivery;

            return response()->json([
                'success' => true,
                'message' => 'Cart successfully updated!',
                'item_qty' => $request->quantity,
                'totals' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'delivery_charge' => $delivery,
                    'discount' => 0.00,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $this->cartService->removeFromCart(auth()->id(), $request->product_id);
        
        // Reset coupon
        session()->forget(['coupon_code', 'coupon_discount']);

        return response()->json([
            'success' => true,
            'message' => 'Item successfully removed from cart!'
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        try {
            $userId = auth()->id();
            $subtotal = $this->cartService->getCartTotal($userId);
            $couponData = $this->cartService->applyCoupon($request->code, $subtotal);
            
            session([
                'coupon_code' => $couponData['coupon']->code,
                'coupon_discount' => $couponData['discount']
            ]);

            $tax = round($subtotal * 0.05, 2);
            $delivery = $subtotal >= 500 ? 0.00 : 50.00;
            $discount = $couponData['discount'];
            $total = ($subtotal + $tax + $delivery) - $discount;

            return response()->json([
                'success' => true,
                'message' => 'Coupon code applied successfully!',
                'discount' => $discount,
                'totals' => [
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'delivery_charge' => $delivery,
                    'discount' => $discount,
                    'total' => $total
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function saveForLater($productId)
    {
        $this->cartService->saveForLater(auth()->id(), $productId);
        return back()->with('success', 'Item list preference successfully changed.');
    }

    public function moveToCart($productId)
    {
        $this->cartService->saveForLater(auth()->id(), $productId); // switches state back to active cart
        return back()->with('success', 'Item successfully returned to active cart.');
    }
}
