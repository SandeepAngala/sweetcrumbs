<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Artisan Bakery & Cafe') - Sweet Crumbs Bakery</title>

    <!-- Preload Critical Fonts for Fast Text Rendering & FOUT Prevention -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100..900;1,100..900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    <!-- CSS CDNs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <!-- Removed Turbo for script compatibility -->

    <!-- Vite Styles & Scripts -->
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
<body class="bg-cream font-body text-coffee-800 dark:bg-gray-900 dark:text-gray-200 antialiased min-h-screen flex flex-col">
    
    <!-- Navbar Component -->
    <x-navbar />

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Component -->
    <x-footer />

    <!-- Floating Quick Order Button -->
    <a href="{{ route('products.index') }}" class="floating-order-btn hover:scale-105 group" title="Order Now">
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-out font-bold whitespace-nowrap pr-0 group-hover:pr-2 text-sm">ORDER NOW</span>
        <i class="fa-solid fa-cookie-bite text-xl"></i>
    </a>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 left-6 z-40 hidden items-center justify-center rounded-full bg-cream dark:bg-gray-800 border border-coffee-200 dark:border-gray-700 p-3 shadow-warm transition-transform hover:-translate-y-1 active:scale-95 text-coffee-500 hover:text-coffee-700 dark:text-coffee-300" title="Back to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- Global Toast Alert Container -->
    <div id="toast-container" class="fixed top-24 right-6 z-50 flex flex-col gap-3 max-w-sm w-full"></div>

    <!-- Alert triggers from session -->
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

    @if(session('error'))
        <script>
            (function showError() {
                if (typeof window.showToast === 'function') {
                    window.showToast("{{ session('error') }}", 'error');
                } else {
                    setTimeout(showError, 50);
                }
            })();
        </script>
    @endif

    <!-- AOS Animation script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
