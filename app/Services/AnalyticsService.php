<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AnalyticsService
{
    public function dashboardMetrics(): array
    {
        $paidQuery = Order::where('payment_status', 'paid');

        return [
            'revenue' => (float) (string) $paidQuery->sum('total'),
            'orders_count' => Order::count(),
            'customers_count' => User::where('role', 'customer')->orWhere('role', 'user')->count(),
            'products_count' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_revenue' => (float) (string) Order::where('payment_status', 'paid')
                ->whereDate('created_at', today())
                ->sum('total'),
            'month_revenue' => (float) (string) Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];
    }

    public function monthlySalesChart(int $months = 12): array
    {
        $orders = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths($months))
            ->get(['total', 'created_at']);

        $grouped = $orders->groupBy(fn ($order) => $order->created_at->format('Y-m'))
            ->sortKeys()
            ->map(fn ($group, $month) => [
                'month' => $month,
                'revenue' => (float) (string) $group->sum('total'),
                'orders' => $group->count(),
            ]);

        return [
            'labels' => $grouped->pluck('month')->values()->toArray(),
            'revenue' => $grouped->pluck('revenue')->values()->toArray(),
            'orders' => $grouped->pluck('orders')->values()->toArray(),
        ];
    }

    public function topProducts(int $limit = 10): array
    {
        return \App\Models\OrderItem::with('product:_id,name')
            ->get()
            ->groupBy('product_id')
            ->map(function ($items, $productId) {
                $product = $items->first()->product;
                return (object) [
                    'id' => $productId,
                    'name' => $product->name ?? 'Unknown',
                    'sold_quantity' => $items->sum('quantity'),
                    'total_revenue' => (float) (string) $items->sum('total'),
                ];
            })
            ->sortByDesc('sold_quantity')
            ->take($limit)
            ->values()
            ->toArray();
    }

    public function customerGrowth(int $months = 6): array
    {
        $users = User::where('created_at', '>=', now()->subMonths($months))
            ->get(['created_at']);

        $grouped = $users->groupBy(fn ($user) => $user->created_at->format('Y-m'))->sortKeys();

        return [
            'labels' => $grouped->keys()->toArray(),
            'data' => $grouped->map->count()->values()->toArray(),
        ];
    }

    public function lowStockProducts(int $threshold = null): array
    {
        $threshold = $threshold ?? config('bakery.low_stock_threshold', 5);

        return Product::where('stock', '<=', $threshold)
            ->orderBy('stock')
            ->limit(20)
            ->get(['id', 'name', 'sku', 'stock', 'status'])
            ->toArray();
    }
}
