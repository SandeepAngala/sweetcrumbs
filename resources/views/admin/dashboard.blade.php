@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Greeting Banner -->
    <div class="bg-gradient-to-r from-coffee-800 to-coffee-950 text-white rounded-3xl p-6 shadow-warm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold">Good Day, Chef {{ auth()->user()->name }}! <i class="fa-solid fa-mug-hot text-bakery-gold-400 animate-pulse ml-1"></i></h1>
            <p class="text-xs text-coffee-200 mt-1">Here is a snapshot of sweet operations and bakery revenue today.</p>
        </div>
        <div class="text-sm px-4 py-2 bg-coffee-700/50 rounded-2xl border border-coffee-600/50 text-bakery-gold-200 font-bold shrink-0">
            Shop Status: <span class="text-green-400 font-extrabold">● OPEN & BAKING</span>
        </div>
    </div>

    <!-- Analytics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm hover:shadow-warm transition-shadow duration-300 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Total Revenue</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">₹{{ number_format($revenue, 2) }}</span>
            </div>
            <div class="w-12 h-12 bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
        </div>

        <!-- Orders Count -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm hover:shadow-warm transition-shadow duration-300 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Total Orders</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">{{ $ordersCount }}</span>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>

        <!-- Customers Count -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm hover:shadow-warm transition-shadow duration-300 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Customers</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">{{ $customersCount }}</span>
            </div>
            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Active Products -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm hover:shadow-warm transition-shadow duration-300 flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Products</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">{{ $productsCount }}</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/20 text-amber-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-mug-hot"></i>
            </div>
        </div>
    </div>

    <!-- Chart Panel -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm">
        <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4">Sales Analytics (Trends)</h2>
        <div class="h-[300px] w-full relative">
            <canvas id="salesTrendsChart"></canvas>
        </div>
    </div>

    <!-- Bottom Lists Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders -->
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-coffee-50 dark:border-gray-800">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-bakery-gold-600 dark:text-bakery-gold-400 hover:underline">View Orders List</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-850">
                            <th class="pb-3">Order No</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                        @foreach($recentOrders as $order)
                            <tr>
                                <td class="py-3 font-mono font-bold text-coffee-800 dark:text-gray-300">{{ $order->order_number }}</td>
                                <td class="py-3 text-coffee-900 dark:text-white font-medium">{{ $order->user->name ?? 'Guest User' }}</td>
                                <td class="py-3 font-bold text-coffee-950 dark:text-white">₹{{ number_format($order->total, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider
                                        @if($order->status === 'pending') bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-900
                                        @elseif($order->status === 'confirmed') bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900
                                        @elseif($order->status === 'processing') bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-900
                                        @elseif($order->status === 'shipped') bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-900
                                        @elseif($order->status === 'delivered') bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-900
                                        @else bg-rose-50 dark:bg-rose-950/20 text-rose-500 dark:text-rose-400 border border-rose-100 dark:border-rose-900
                                        @endif
                                    ">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-bakery-gold-600 hover:text-bakery-gold-700 font-bold text-xs"><i class="fa-solid fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products & Low Stock Summary -->
        <div class="space-y-6">
            
            <!-- Top Products -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 pb-2 border-b border-coffee-50 dark:border-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-crown text-amber-500"></i> Top Products
                </h2>
                <div class="space-y-4">
                    @foreach($topProducts as $tp)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-coffee-900 dark:text-white max-w-[150px] truncate">{{ $tp->name }}</span>
                            <div class="text-right">
                                <span class="text-xs text-coffee-400 dark:text-gray-500 block">{{ $tp->sold_quantity }} Sold</span>
                                <span class="font-bold text-bakery-gold-600 dark:text-bakery-gold-400">₹{{ number_format($tp->total_revenue, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 pb-2 border-b border-coffee-50 dark:border-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 animate-pulse"></i> Low Stock Alerts
                </h2>
                <div class="space-y-3">
                    @forelse($lowStockProducts as $lp)
                        <div class="flex items-center justify-between text-sm p-2 bg-rose-50/50 dark:bg-rose-950/20 rounded-xl border border-rose-100/50 dark:border-rose-900/50">
                            <span class="font-medium text-coffee-900 dark:text-white truncate max-w-[150px]">{{ $lp->name }}</span>
                            <span class="px-2 py-0.5 bg-rose-500 text-white rounded-full text-xxs font-extrabold">{{ $lp->stock }} Left</span>
                        </div>
                    @empty
                        <p class="text-xs text-coffee-400 dark:text-gray-500 italic text-center py-2">All products well stocked! <i class="fa-solid fa-bread-slice text-amber-600/80 ml-1"></i></p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>

<script>
    {
        const initChart = function () {
            const chartCanvas = document.getElementById('salesTrendsChart');
            if (!chartCanvas) return;

            // Prevent multiple instances on the same canvas
            const existingChart = Chart.getChart(chartCanvas);
            if (existingChart) {
                existingChart.destroy();
            }

            const ctx = chartCanvas.getContext('2d');
            const chartData = @json($chartData);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Sales Revenue (₹)',
                        data: chartData.data,
                        borderColor: '#b45309', // bakery gold/coffee accent
                        backgroundColor: 'rgba(180, 83, 9, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#b45309',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(180, 83, 9, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        };

        document.addEventListener('DOMContentLoaded', initChart);
        // Fallback for initial load
        if (document.readyState !== 'loading') {
            initChart();
        }
    }
</script>
@endsection
