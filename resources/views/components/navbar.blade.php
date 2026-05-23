<nav id="main-navbar" class="sticky top-0 z-50 w-full transition-all duration-300 border-b border-coffee-100/5 bg-cream/80 dark:bg-gray-900/80 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <i class="fa-solid fa-cookie-bite text-3xl text-bakery-gold-400 group-hover:rotate-12 transition-transform duration-300"></i>
            <span class="font-display font-extrabold text-xl tracking-wider bg-gradient-to-r from-coffee-700 via-coffee-500 to-bakery-gold-400 bg-clip-text text-transparent dark:from-white dark:to-bakery-gold-300">
                SWEET CRUMBS
            </span>
        </a>

        <!-- Live Search -->
        <div class="hidden lg:block relative flex-1 max-w-xs mx-4">
            <input type="search" id="global-search-input" placeholder="Search menu..."
                   class="w-full rounded-xl border border-coffee-200/60 bg-white/60 dark:bg-gray-800/60 px-4 py-2 text-sm focus:border-gold focus:ring-gold" autocomplete="off" />
            <div id="search-suggestions" class="hidden absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-900 rounded-2xl shadow-warm-lg border border-coffee-100/10 overflow-hidden z-50 max-h-80 overflow-y-auto"></div>
        </div>

        <!-- Main Desktop Navigation -->
        <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-coffee-800 dark:text-gray-200">
            <a href="{{ route('home') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('home') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('about') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Our Story</a>
            <a href="{{ route('products.index') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('products.*') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Menu</a>
            <a href="{{ route('custom-cake') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('custom-cake') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Custom Cakes</a>
            <a href="{{ route('blog.index') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('blog.*') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Blog</a>
            <a href="{{ route('contact') }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-350 {{ request()->routeIs('contact') ? 'text-gold dark:text-gold font-bold border-b-2 border-gold pb-1' : '' }}">Contact</a>
        </div>


        <!-- Global Interactive Tools -->
        <div class="flex items-center gap-4">
            
            <!-- Dark mode Toggle -->
            <button id="dark-mode-toggle" class="p-2.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-600 dark:text-coffee-300 transition-all active:scale-95" title="Toggle theme">
                <i class="fa-solid fa-circle-half-stroke text-lg"></i>
            </button>

            @auth
                @php $cartCount = $navbarCartCount ?? 0; @endphp
                <!-- Wishlist link -->
                <a href="{{ route('wishlist.index') }}" class="p-2.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-600 dark:text-coffee-300 transition-all relative active:scale-95" title="Wishlist">
                    <i class="fa-regular fa-heart text-lg"></i>
                </a>

                <!-- Cart Dropdown trigger -->
                <a href="{{ route('cart.index') }}" class="p-2.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-600 dark:text-coffee-300 transition-all relative active:scale-95" title="Cart">
                    <i class="fa-solid fa-bag-shopping text-lg"></i>
                    <span class="cart-count-badge absolute -top-0.5 -right-0.5 w-5 h-5 flex items-center justify-center bg-rose-500 text-white rounded-full text-[10px] font-bold shadow {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
            @else
                @php $cartCount = $navbarCartCount ?? 0; @endphp
                <a href="{{ route('cart.index') }}" class="p-2.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-600 dark:text-coffee-300 transition-all relative active:scale-95" title="Cart">
                    <i class="fa-solid fa-bag-shopping text-lg"></i>
                    <span class="cart-count-badge absolute -top-0.5 -right-0.5 w-5 h-5 flex items-center justify-center bg-rose-500 text-white rounded-full text-[10px] font-bold shadow {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
            @endauth

            @auth

                <!-- User Dropdown profile -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-700 dark:text-gray-300 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-coffee-300 flex items-center justify-center text-white font-bold text-sm shadow shadow-coffee-500/10">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-3 w-52 bg-white dark:bg-gray-900 border border-coffee-100/10 rounded-2xl shadow-warm-lg overflow-hidden py-1 z-50">
                        <div class="px-4 py-2 border-b border-coffee-100/5 text-xs text-coffee-400">Welcome, {{ auth()->user()->name }}</div>
                        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-coffee-700 dark:text-gray-200 hover:bg-coffee-50 dark:hover:bg-gray-800"><i class="fa-solid fa-user-circle w-5"></i> Dashboard</a>
                        @if(auth()->user()->isStaff())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-coffee-700 dark:text-gray-200 hover:bg-coffee-50 dark:hover:bg-gray-800 font-semibold text-bakery-gold-500"><i class="fa-solid fa-chef-hat w-5"></i> Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 px-4 py-2 text-sm text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/20 w-full text-left"><i class="fa-solid fa-sign-out w-5"></i> Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl border border-coffee-200 text-coffee-600 hover:bg-coffee-100/20 transition-all font-semibold text-sm">Login</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-coffee-500 to-bakery-gold-300 text-white font-semibold shadow hover:scale-105 active:scale-95 transition-all text-sm">Register</a>
            @endauth

            <!-- Mobile Hamburger Menu Button -->
            <button class="md:hidden p-2.5 rounded-xl hover:bg-coffee-100/50 dark:hover:bg-gray-800 text-coffee-800 dark:text-white" onclick="document.getElementById('mobile-drawer').classList.toggle('hidden')">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer" class="hidden md:hidden bg-cream dark:bg-gray-900 border-t border-coffee-100/10 py-4 px-6 flex flex-col gap-4 text-sm font-semibold text-coffee-800 dark:text-gray-200 animate-slide-up">
        <a href="{{ route('home') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('home') ? 'text-gold' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('about') ? 'text-gold' : '' }}">Our Story</a>
        <a href="{{ route('products.index') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('products.*') ? 'text-gold' : '' }}">Menu</a>
        <a href="{{ route('custom-cake') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('custom-cake') ? 'text-gold' : '' }}">Custom Cakes</a>
        <a href="{{ route('blog.index') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('blog.*') ? 'text-gold' : '' }}">Blog</a>
        <a href="{{ route('contact') }}" class="hover:text-gold py-1 transition-colors {{ request()->routeIs('contact') ? 'text-gold' : '' }}">Contact</a>
    </div>

</nav>
