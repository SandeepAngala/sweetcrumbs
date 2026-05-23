<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(protected CategoryRepositoryInterface $categories) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => CategoryResource::collection($this->categories->tree()),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $category = $this->categories->findBySlug($slug);

        if (! $category || ! $category->is_active) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json([
            'data' => new CategoryResource($category),
            'products' => ProductResource::collection($category->products),
        ]);
    }
}
