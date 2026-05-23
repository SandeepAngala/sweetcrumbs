<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(protected AnalyticsService $analytics) {}

    public function index(Request $request): JsonResponse|\Illuminate\View\View
    {
        $metrics = $this->analytics->dashboardMetrics();

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $metrics]);
        }

        return view('admin.analytics', compact('metrics'));
    }

    public function charts(Request $request): JsonResponse
    {
        return response()->json([
            'monthly_sales' => $this->analytics->monthlySalesChart(),
            'top_products' => $this->analytics->topProducts(),
            'customer_growth' => $this->analytics->customerGrowth(),
            'low_stock' => $this->analytics->lowStockProducts(),
        ]);
    }
}
