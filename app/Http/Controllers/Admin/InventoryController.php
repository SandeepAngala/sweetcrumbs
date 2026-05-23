<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(protected InventoryService $inventoryService) {}

    public function index(Request $request): JsonResponse|\Illuminate\View\View
    {
        $products = Product::orderBy('stock')->paginate(20);
        $logs = InventoryLog::with(['product', 'user'])->latest()->paginate(20);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'products' => $products,
                'logs' => $logs,
            ]);
        }

        return view('admin.inventory.index', compact('products', 'logs'));
    }

    public function adjust(Request $request, Product $product): JsonResponse
    {
        $data = $request->validate([
            'quantity_change' => 'required|integer|not_in:0',
            'type' => 'required|in:in,out,adjustment',
            'notes' => 'nullable|string|max:500',
        ]);

        $change = (int) $data['quantity_change'];
        if ($data['type'] === 'out' && $change > 0) {
            $change = -$change;
        }

        $product = $this->inventoryService->adjustStock(
            $product,
            $change,
            $data['type'],
            $request->user()->id,
            null,
            null,
            $data['notes'] ?? null
        );

        return response()->json([
            'message' => 'Inventory updated.',
            'product' => $product->only(['id', 'name', 'stock', 'status']),
        ]);
    }
}
