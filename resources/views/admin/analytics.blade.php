@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="analyticsCharts()" x-init="loadCharts()">
    <h1 class="font-display text-2xl font-bold text-coffee-900 dark:text-white">Analytics Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach([
            'revenue' => 'Total Revenue',
            'orders_count' => 'Total Orders',
            'customers_count' => 'Customers',
            'month_revenue' => 'This Month',
        ] as $key => $label)
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-5 border border-coffee-100 dark:border-gray-800 shadow-sm">
            <p class="text-sm text-coffee-500">{{ $label }}</p>
            <p class="text-2xl font-bold text-coffee-900 dark:text-white">
                {{ in_array($key, ['revenue', 'month_revenue']) ? '₹'.number_format($metrics[$key] ?? 0, 0) : number_format($metrics[$key] ?? 0) }}
            </p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-coffee-100 dark:border-gray-800">
            <h2 class="font-semibold mb-4">Monthly Sales</h2>
            <canvas id="salesChart" height="120"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-coffee-100 dark:border-gray-800">
            <h2 class="font-semibold mb-4">Customer Growth</h2>
            <canvas id="customersChart" height="120"></canvas>
        </div>
    </div>
</div>

<script>
function analyticsCharts() {
    return {
        async loadCharts() {
            try {
                const res = await fetch('{{ route('admin.analytics.charts') }}', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                new Chart(document.getElementById('salesChart'), {
                    type: 'line',
                    data: {
                        labels: data.monthly_sales.labels,
                        datasets: [{
                            label: 'Revenue (₹)',
                            data: data.monthly_sales.revenue,
                            borderColor: '#b45309',
                            tension: 0.3,
                        }]
                    }
                });

                new Chart(document.getElementById('customersChart'), {
                    type: 'bar',
                    data: {
                        labels: data.customer_growth.labels,
                        datasets: [{
                            label: 'New Customers',
                            data: data.customer_growth.data,
                            backgroundColor: '#d97706',
                        }]
                    }
                });
            } catch (e) {
                console.error('Failed to load charts', e);
            }
        }
    };
}
</script>
@endsection
