<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartItemRequest;
use App\Http\Requests\Api\CouponRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(Request $request): JsonResponse
    {
        $items = $this->cartService->getCart($request->user()->id);
        $subtotal = $this->cartService->getCartTotal($request->user()->id);

        return response()->json([
            'data' => CartResource::collection($items),
            'summary' => $this->buildSummary($subtotal),
        ]);
    }

    public function store(CartItemRequest $request): JsonResponse
    {
        try {
            $this->cartService->addToCart(
                $request->user()->id,
                $request->product_id,
                $request->quantity ?? 1
            );
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Added to cart.', 'count' => $this->cartService->getCartCount($request->user()->id)]);
    }

    public function update(CartItemRequest $request): JsonResponse
    {
        try {
            $this->cartService->updateQuantity($request->user()->id, $request->product_id, $request->quantity);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => 'Cart updated.']);
    }

    public function destroy(Request $request, int $productId): JsonResponse
    {
        $this->cartService->removeFromCart($request->user()->id, $productId);

        return response()->json(['message' => 'Item removed from cart.']);
    }

    public function applyCoupon(CouponRequest $request): JsonResponse
    {
        $subtotal = $this->cartService->getCartTotal($request->user()->id);

        try {
            $result = $this->cartService->applyCoupon($request->code, $subtotal);

            return response()->json([
                'coupon' => $result['coupon']->code,
                'discount' => $result['discount'],
                'summary' => $this->buildSummary($subtotal, $result['discount']),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    protected function buildSummary(float $subtotal, float $discount = 0): array
    {
        $taxRate = config('bakery.tax_rate', 0.05);
        $tax = round($subtotal * $taxRate, 2);
        $delivery = $subtotal >= config('bakery.free_delivery_threshold', 500)
            ? 0
            : config('bakery.default_delivery_charge', 50);

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_charge' => $delivery,
            'discount' => $discount,
            'total' => max(0, $subtotal + $tax + $delivery - $discount),
        ];
    }
}
