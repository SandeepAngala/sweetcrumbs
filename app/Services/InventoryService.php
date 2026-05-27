<?php

namespace App\Services;

use App\Models\InventoryLog;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\LowStockAlert;
use Illuminate\Support\Facades\Notification;

class InventoryService
{
    public function adjustStock(
        Product $product,
        int $quantityChange,
        string $type,
        mixed $userId = null,
        ?string $referenceType = null,
        mixed $referenceId = null,
        ?string $notes = null
    ): Product {
        $stockBefore = $product->stock;
        $stockAfter = max(0, $stockBefore + $quantityChange);

        $product->update(['stock' => $stockAfter]);

        InventoryLog::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'type' => $type,
            'quantity_change' => $quantityChange,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
        ]);

        $threshold = config('bakery.low_stock_threshold', 5);
        if ($stockAfter <= $threshold && $stockAfter > 0) {
            $this->notifyLowStock($product);
        }

        if ($stockAfter === 0) {
            $product->update(['status' => 'inactive']);
        }

        return $product->fresh();
    }

    public function deductForOrder(Product $product, int $quantity, mixed $orderId, mixed $userId = null): Product
    {
        return $this->adjustStock(
            $product,
            -$quantity,
            'order',
            $userId,
            Order::class,
            $orderId,
            'Stock deducted for order'
        );
    }

    public function restoreFromCancellation(Product $product, int $quantity, mixed $orderId, mixed $userId = null): Product
    {
        return $this->adjustStock(
            $product,
            $quantity,
            'return',
            $userId,
            Order::class,
            $orderId,
            'Stock restored from cancelled order'
        );
    }

    protected function notifyLowStock(Product $product): void
    {
        $admins = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new LowStockAlert($product));
        }
    }
}
