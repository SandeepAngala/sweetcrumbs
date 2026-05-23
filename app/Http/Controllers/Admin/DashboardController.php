<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $revenue = Order::where('payment_status', 'paid')->sum('total');
        $ordersCount = Order::count();
        $customersCount = User::where('role', 'user')->count();
        $productsCount = Product::count();

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as sold_quantity'), DB::raw('SUM(order_items.total) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('sold_quantity', 'desc')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<', 5)->take(5)->get();

        // Chart Data (Mocking monthly sales data)
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [12000, 19000, 3000, 5000, 2000, 3000, 45000, 50000, 60000, 80000, 95000, 120000]
        ];

        return view('admin.dashboard', compact(
            'revenue', 'ordersCount', 'customersCount', 'productsCount',
            'recentOrders', 'topProducts', 'lowStockProducts', 'chartData'
        ));
    }
}
