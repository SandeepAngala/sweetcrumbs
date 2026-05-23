@extends('layouts.dashboard')

@section('title', 'Customer Dashboard')

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Premium Welcome Header -->
    <div class="bg-gradient-to-r from-coffee-800 to-coffee-950 text-white rounded-3xl p-8 shadow-warm relative overflow-hidden">
        <div class="absolute right-0 bottom-0 opacity-10 text-9xl"><i class="fa-solid fa-cookie-bite"></i></div>
        <span class="text-xs font-semibold uppercase tracking-widest text-bakery-gold-300">Welcome Back</span>
        <h1 class="font-display text-3xl sm:text-4xl font-black mt-1">Hello, {{ $user->name }}!</h1>
        <p class="text-coffee-200 text-sm mt-2 max-w-md">
            Ready for another batch of freshly baked treats? Check your orders, manage address details, or browse your wishlist.
        </p>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        
        <!-- Stat Card 1 -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-coffee-100 dark:border-gray-700 shadow-warm flex items-center justify-between group hover:border-bakery-gold-400 transition-all duration-300">
            <div>
                <span class="text-xs font-semibold uppercase text-coffee-400 dark:text-gray-500 tracking-wider">Total Orders</span>
                <span class="text-3xl font-black text-coffee-900 dark:text-white block mt-1">{{ $ordersCount }}</span>
            </div>
            <div class="w-12 h-12 bg-coffee-50 dark:bg-gray-700/50 rounded-2xl flex items-center justify-center text-xl text-coffee-600 dark:text-coffee-300 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-coffee-100 dark:border-gray-700 shadow-warm flex items-center justify-between group hover:border-bakery-gold-400 transition-all duration-300">
            <div>
                <span class="text-xs font-semibold uppercase text-coffee-400 dark:text-gray-500 tracking-wider">In Progress</span>
                <span class="text-3xl font-black text-coffee-900 dark:text-white block mt-1">{{ $pendingOrdersCount }}</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/20 rounded-2xl flex items-center justify-center text-xl text-amber-500 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-coffee-100 dark:border-gray-700 shadow-warm flex items-center justify-between group hover:border-bakery-gold-400 transition-all duration-300">
            <div>
                <span class="text-xs font-semibold uppercase text-coffee-400 dark:text-gray-500 tracking-wider">Saved Sweets</span>
                <span class="text-3xl font-black text-coffee-900 dark:text-white block mt-1">{{ $wishlistCount }}</span>
            </div>
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-950/20 rounded-2xl flex items-center justify-center text-xl text-rose-500 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>

    </div>

    <!-- Loyalty Rewards Panel -->
    <div class="bg-gradient-to-br from-amber-50 to-bakery-gold-100 dark:from-gray-800 dark:to-gray-800/80 rounded-3xl border border-bakery-gold-200 dark:border-gray-700 p-8 shadow-warm relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute -right-8 -top-8 w-24 h-24 rounded-full bg-bakery-gold-200/30 blur-2xl"></div>
        
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-bakery-gold-500 text-coffee-950 text-xxs font-extrabold uppercase tracking-widest rounded-full mb-3 shadow-sm">
                <i class="fa-solid fa-star text-[8px]"></i> Loyalty Club
            </div>
            <h2 class="font-display text-2xl font-bold text-coffee-950 dark:text-white">Earn Rewards on Every Bite!</h2>
            <p class="text-coffee-700 dark:text-gray-300 text-sm mt-2 max-w-xl">
                Redeem your <span class="font-bold text-bakery-gold-700 dark:text-bakery-gold-400">{{ $user->loyalty_points ?? 0 }} Sweet Points</span> at checkout for exclusive discounts. Every ₹10 spent gets you 1 point!
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-950 text-white rounded-full font-bold text-sm shadow-warm transition-transform active:scale-95 text-center shrink-0">
            Browse Menu & Earn
        </a>
    </div>

    <!-- Recent Orders List -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-6 shadow-warm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-coffee-950 dark:text-white">Recent Orders</h2>
            <a href="{{ route('dashboard.orders') }}" class="text-xs font-bold text-bakery-gold-600 dark:text-bakery-gold-400 hover:underline flex items-center gap-1">
                View All <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="text-center py-10 text-coffee-500 dark:text-gray-400 italic">
                <p class="mb-4">No recent orders found.</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2.5 bg-coffee-50 hover:bg-coffee-100 text-coffee-700 font-bold rounded-full text-xs transition-colors">
                    Order Your First Dessert <i class="fa-solid fa-cake-candles ml-1"></i>
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($recentOrders as $order)
                    <div class="p-6 bg-coffee-50/50 dark:bg-gray-950/20 rounded-2xl border border-coffee-50 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-6 transition-all hover:bg-coffee-50 dark:hover:bg-gray-950/40">
                        <!-- Order basics -->
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-sm font-bold text-coffee-800 dark:text-gray-300">{{ $order->order_number }}</span>
                                <span class="text-xs text-coffee-400 dark:text-gray-500">{{ $order->created_at->format('M j, Y') }}</span>
                            </div>
                            
                            <!-- Delivery slot details -->
                            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">
                                Delivery Scheduled: <span class="font-medium text-coffee-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($order->delivery_date)->format('M j, Y') }} ({{ $order->delivery_time_slot }})</span>
                            </p>

                            <!-- Status Bar Tracker -->
                            <div class="mt-4 flex items-center gap-1.5">
                                @php
                                    $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                                    $currentIdx = array_search($order->status, $statuses);
                                    $isCancelled = $order->status === 'cancelled';
                                @endphp
                                
                                @if($isCancelled)
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/30 text-rose-500 text-xxs font-extrabold uppercase tracking-wider border border-rose-100 dark:border-rose-950/40">Cancelled</span>
                                @else
                                    @foreach($statuses as $idx => $st)
                                        <div class="h-1.5 w-8 rounded-full {{ $idx <= $currentIdx ? 'bg-bakery-gold-500' : 'bg-coffee-100 dark:bg-gray-700' }}" title="{{ ucfirst($st) }}"></div>
                                    @endforeach
                                    <span class="ml-2 text-xxs font-extrabold uppercase tracking-wider text-bakery-gold-600 dark:text-bakery-gold-400">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Price and link -->
                        <div class="flex items-center justify-between md:justify-end gap-6 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-coffee-100 dark:border-gray-800">
                            <div>
                                <span class="text-xs text-coffee-400 dark:text-gray-500 block text-left md:text-right">Grand Total</span>
                                <span class="text-lg font-black text-coffee-950 dark:text-white">₹{{ number_format($order->total, 2) }}</span>
                            </div>
                            
                            <a href="{{ route('dashboard.orders.show', $order->order_number) }}" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white rounded-xl text-xs font-bold shadow-md transition-all active:scale-95">
                                Track Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
