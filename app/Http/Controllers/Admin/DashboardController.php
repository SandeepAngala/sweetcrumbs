<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;

class DashboardController extends Controller
{
    public function __construct(protected AnalyticsService $analytics) {}

    public function index()
    {
        $metrics = $this->analytics->dashboardMetrics();
        $chartData = $this->analytics->monthlySalesChart(6);
        $topProducts = $this->analytics->topProducts(5);
        $lowStockProducts = $this->analytics->lowStockProducts();

        return view('admin.dashboard', [
            'revenue' => $metrics['revenue'],
            'ordersCount' => $metrics['orders_count'],
            'customersCount' => $metrics['customers_count'],
            'productsCount' => $metrics['products_count'],
            'recentOrders' => \App\Models\Order::with('user')->latest()->take(5)->get(),
            'topProducts' => collect($topProducts),
            'lowStockProducts' => collect($lowStockProducts),
            'chartData' => [
                'labels' => $chartData['labels'] ?: ['No data'],
                'data' => $chartData['revenue'] ?: [0],
            ],
            'todayRevenue' => $metrics['today_revenue'],
            'monthRevenue' => $metrics['month_revenue'],
        ]);
    }
}
