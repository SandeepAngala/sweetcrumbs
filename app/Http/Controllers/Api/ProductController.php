<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductRepositoryInterface $products) {}

    public function index(Request $request): JsonResponse
    {
        $paginated = $this->products->paginate($request->only([
            'category_id', 'category_slug', 'search', 'featured', 'in_stock', 'sort',
        ]), (int) $request->get('per_page', 15));

        return response()->json([
            'data' => ProductResource::collection($paginated),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        return response()->json([
            'data' => ProductResource::collection($this->products->featured()),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = $this->products->findBySlug($slug);

        if (! $product || $product->status !== 'active') {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return response()->json(['data' => new ProductResource($product)]);
    }

    public function reviews(string $slug): JsonResponse
    {
        $product = $this->products->findBySlug($slug);

        if (! $product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $reviews = $product->reviews()->with('user')->latest()->paginate(10);

        return response()->json([
            'data' => ReviewResource::collection($reviews),
            'meta' => [
                'current_page' => $reviews->currentPage(),
                'total' => $reviews->total(),
            ],
        ]);
    }
}
