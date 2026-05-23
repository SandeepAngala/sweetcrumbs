<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function dashboardMetrics(): array
    {
        $paidQuery = Order::where('payment_status', 'paid');

        return [
            'revenue' => (float) $paidQuery->sum('total'),
            'orders_count' => Order::count(),
            'customers_count' => User::where('role', 'customer')->orWhere('role', 'user')->count(),
            'products_count' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_revenue' => (float) Order::where('payment_status', 'paid')
                ->whereDate('created_at', today())
                ->sum('total'),
            'month_revenue' => (float) Order::where('payment_status', 'paid')
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
                'revenue' => (float) $group->sum('total'),
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
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as sold_quantity'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('sold_quantity')
            ->limit($limit)
            ->get()
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
