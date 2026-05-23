<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Sweet Crumbs Bakery</title>

    <!-- Preload Critical Fonts for Fast Text Rendering & FOUT Prevention -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    
    <!-- CSS CDNs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- ChartJS for high-end sales monitoring -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Removed Turbo for script compatibility -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom brand progress bar for SPA navigation */
        .turbo-progress-bar {
            background: linear-gradient(to right, #b45309, #d97706) !important;
            height: 3px !important;
            box-shadow: 0 0 10px rgba(180, 83, 9, 0.4);
        }
    </style>
</head>
<body class="bg-coffee-50 dark:bg-gray-950 font-body text-coffee-800 dark:text-gray-200 antialiased min-h-screen flex">

    <!-- Sidebar Admin Menu -->
    <aside class="w-64 bg-coffee-800 text-white flex flex-col shadow-warm shrink-0 hidden md:flex border-r border-coffee-700">
        <div class="p-6 border-b border-coffee-700 flex items-center gap-3">
            <i class="fa-solid fa-cookie-bite text-2xl text-bakery-gold-300"></i>
            <span class="font-display font-bold text-lg tracking-wider text-bakery-gold-200">Sweet Crumbs</span>
        </div>
        
        <nav class="flex-grow p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-chart-line w-5"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-cookie-bite w-5"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-folder w-5"></i> Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-receipt w-5"></i> Orders
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-users w-5"></i> Customers
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.coupons.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-tags w-5"></i> Coupons
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.blogs.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-newspaper w-5"></i> Blog
            </a>
            <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-images w-5"></i> Banners
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-star w-5"></i> Reviews
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-coffee-600 text-bakery-gold-100 font-semibold' : 'text-coffee-100' }}">
                <i class="fa-solid fa-envelope w-5"></i> Support
            </a>
        </nav>

        <div class="p-4 border-t border-coffee-700 flex flex-col gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-coffee-700 text-coffee-100 transition-colors">
                <i class="fa-solid fa-globe w-5"></i> Public Site
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-950/20 text-rose-300 w-full text-left transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Workspace -->
    <div class="flex-grow flex flex-col min-w-0">
        
        <!-- Header Panel -->
        <header class="h-16 border-b border-coffee-100 dark:border-gray-800 bg-white dark:bg-gray-900 flex items-center justify-between px-6 z-10 shrink-0">
            <button class="md:hidden text-coffee-800 dark:text-white" onclick="document.querySelector('aside').classList.toggle('hidden')">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            
            <div class="font-semibold text-lg text-coffee-900 dark:text-white">Admin Dashboard</div>

            <div class="flex items-center gap-4">
                <button id="dark-mode-toggle" class="p-2 rounded-lg bg-coffee-50 hover:bg-coffee-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-coffee-600 dark:text-coffee-300">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>
                
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-coffee-900 dark:text-white">{{ auth()->user()->name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded bg-bakery-gold-300 text-white font-bold">Chef Admin</span>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Space -->
        <div class="flex-grow p-6 overflow-y-auto">
            @yield('content')
        </div>
    </div>

    <!-- Global Toast container -->
    <div id="toast-container" class="fixed top-20 right-6 z-50 flex flex-col gap-3 max-w-sm w-full"></div>
    
    @if(session('success'))
        <script>
            (function showSuccess() {
                if (typeof window.showToast === 'function') {
                    window.showToast("{{ session('success') }}", 'success');
                } else {
                    setTimeout(showSuccess, 50);
                }
            })();
        </script>
    @endif
</body>
</html>
