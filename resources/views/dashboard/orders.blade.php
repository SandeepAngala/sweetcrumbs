@extends('layouts.dashboard')

@section('title', 'My Orders')

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Header Section -->
    <div class="border-b border-coffee-100 dark:border-gray-800 pb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Order History</h1>
            <p class="text-sm text-coffee-600 dark:text-gray-400 mt-1">Track and manage your signature bakery orders</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-bakery-gold-500 hover:bg-bakery-gold-600 text-coffee-950 font-bold rounded-2xl text-sm shadow-warm transition-transform active:scale-95 text-center">
            <i class="fa-solid fa-cookie"></i> Order New Treats
        </a>
    </div>

    @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-12 text-center shadow-warm">
            <div class="w-20 h-20 bg-coffee-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-6 text-coffee-400 dark:text-coffee-300 border border-coffee-100 dark:border-gray-600 animate-bounce">
                <i class="fa-solid fa-bread-slice text-3xl text-bakery-gold-500"></i>
            </div>
            <h2 class="font-display text-2xl font-bold text-coffee-900 dark:text-white mb-2">No Orders Yet</h2>
            <p class="text-coffee-600 dark:text-gray-300 max-w-md mx-auto mb-6">
                You haven't ordered any of our delicious cakes or pastries yet! Explore our mouth-watering collections now.
            </p>
            <a href="{{ route('products.index') }}" class="px-8 py-4 bg-coffee-800 hover:bg-coffee-950 text-white font-bold rounded-full text-sm shadow-warm transition-all">
                Start Ordering
            </a>
        </div>
    @else
        <!-- Order List Grid -->
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-6 shadow-warm hover:shadow-xl transition-all duration-300">
                    
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-coffee-50 dark:border-gray-700 pb-4 mb-4">
                        <!-- Left Details -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 w-full">
                            <div>
                                <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500">Order Number</span>
                                <span class="font-mono text-sm font-bold text-coffee-900 dark:text-white block mt-0.5">{{ $order->order_number }}</span>
                            </div>
                            
                            <div>
                                <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500">Date Ordered</span>
                                <span class="text-sm font-medium text-coffee-700 dark:text-gray-300 block mt-0.5">{{ $order->created_at->format('M j, Y') }}</span>
                            </div>

                            <div>
                                <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500">Total Amount</span>
                                <span class="text-sm font-black text-bakery-gold-600 dark:text-bakery-gold-400 block mt-0.5">₹{{ number_format($order->total, 2) }}</span>
                            </div>

                            <div>
                                <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-0.5">Order Status</span>
                                @if($order->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 dark:bg-yellow-950/30 text-yellow-600 dark:text-yellow-400 text-xxs font-bold uppercase tracking-wider border border-yellow-200 dark:border-yellow-800">Pending</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 text-xxs font-bold uppercase tracking-wider border border-blue-200 dark:border-blue-800">Confirmed</span>
                                @elseif($order->status === 'processing')
                                    <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 text-xxs font-bold uppercase tracking-wider border border-indigo-200 dark:border-indigo-800 font-semibold animate-pulse">Processing</span>
                                @elseif($order->status === 'shipped')
                                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 dark:bg-purple-950/30 text-purple-600 dark:text-purple-400 text-xxs font-bold uppercase tracking-wider border border-purple-200 dark:border-purple-800 font-semibold">Out For Delivery</span>
                                @elseif($order->status === 'delivered')
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800">Delivered</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/30 text-rose-500 dark:text-rose-400 text-xxs font-bold uppercase tracking-wider border border-rose-100 dark:border-rose-900">Cancelled</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Summary Panel -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                        <div class="text-xs text-coffee-600 dark:text-gray-400">
                            <span class="font-bold text-coffee-800 dark:text-gray-300">Delivery Slot:</span> 
                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('l, F j, Y') }} at <span class="underline font-semibold">{{ $order->delivery_time_slot }}</span>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('dashboard.orders.show', $order->order_number) }}" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white rounded-xl text-xs font-bold shadow-md transition-all active:scale-95 flex items-center gap-1.5">
                                <i class="fa-solid fa-magnifying-glass-chart"></i> Track Order
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Custom Styled Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
