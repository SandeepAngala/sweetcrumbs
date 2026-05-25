@extends('layouts.app')

@section('content')
<div class="py-12 bg-cream dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Welcome banner or page title for mobile -->
        <div class="lg:hidden mb-6 text-center">
            <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Customer Portal</h1>
            <p class="text-xs text-coffee-600 dark:text-gray-400 mt-1">Manage your sweet orders & rewards</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Dashboard Sidebar -->
            <aside class="w-full lg:w-80 shrink-0">
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 shadow-warm p-6 sticky top-28">
                    
                    <!-- User Profile Brief -->
                    <div class="flex items-center gap-4 pb-6 mb-6 border-b border-coffee-50 dark:border-gray-700">
                        <div class="w-14 h-14 rounded-full bg-bakery-gold-100 dark:bg-bakery-gold-950/30 flex items-center justify-center border border-bakery-gold-300">
                            <i class="fa-solid fa-mug-hot text-2xl text-bakery-gold-600"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="font-bold text-coffee-900 dark:text-white truncate">{{ auth()->user()->name }}</h2>
                            <p class="text-xs text-coffee-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            <span class="inline-block mt-1 text-xxs px-2.5 py-0.5 rounded-full bg-bakery-gold-500 text-coffee-950 font-bold uppercase tracking-widest">
                                Gold Member
                            </span>
                        </div>
                    </div>

                    <!-- Loyalty Points Counter Card -->
                    <div class="bg-coffee-50 dark:bg-gray-700/50 rounded-2xl p-4 border border-coffee-100 dark:border-gray-600 mb-6 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-coffee-500 dark:text-coffee-300 block">Sweet Points</span>
                            <span class="text-2xl font-black text-bakery-gold-600 dark:text-bakery-gold-400">
                                {{ auth()->user()->loyalty_points ?? 0 }}
                            </span>
                        </div>
                        <i class="fa-solid fa-wand-magic-sparkles text-2xl text-bakery-gold-400"></i>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="space-y-1.5">
                        <a href="{{ route('dashboard.index') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('dashboard.index') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-gauge-high"></i> Dashboard
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>

                        <a href="{{ route('dashboard.orders') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('dashboard.orders') || request()->routeIs('dashboard.orders.show') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-clock-rotate-left"></i> My Orders
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>

                        <a href="{{ route('dashboard.addresses') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('dashboard.addresses') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-map-location-dot"></i> Saved Addresses
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>

                        <a href="{{ route('wishlist.index') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('wishlist.index') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-heart"></i> My Wishlist
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>

                        <a href="{{ route('dashboard.notifications') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('dashboard.notifications') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-bell"></i> Notifications
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>

                        <a href="{{ route('dashboard.profile') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-semibold text-sm {{ request()->routeIs('dashboard.profile') ? 'bg-coffee-800 text-white shadow-md' : 'text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700/50' }}">
                            <span class="flex items-center gap-3">
                                <i class="fa-solid fa-user-gear"></i> Profile Settings
                            </span>
                            <i class="fa-solid fa-chevron-right text-xs opacity-60"></i>
                        </a>
                    </nav>

                    <!-- Logout Button -->
                    <div class="mt-8 pt-6 border-t border-coffee-50 dark:border-gray-700">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/20 font-bold text-sm transition-colors text-left">
                                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                            </button>
                        </form>
                    </div>

                </div>
            </aside>

            <!-- Main Inner Workspace -->
            <main class="flex-grow min-w-0">
                @yield('dashboard_content')
            </main>

        </div>
    </div>
</div>
@endsection
