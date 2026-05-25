@extends('layouts.app')

@section('title', 'Premium Tea Lounge & Café')

@section('content')
<!-- 1. LUXURIOUS HERO SLIDER / DYNAMIC BANNER -->
<section class="relative min-h-[90vh] flex items-center justify-center bg-gradient-to-b from-[#2C1810] to-[#120703] text-white overflow-hidden py-24 px-6">
    <!-- Overlay Background Decorative Patterns -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-coffee-800/30 via-transparent to-transparent opacity-75"></div>
    <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-gold/5 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full bg-bakery-pink-200/5 blur-3xl"></div>
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/dark-wood.png')] opacity-10 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full relative z-10">
        @if($banners && $banners->count() > 0)
            <!-- Multi-Banner Carousel Wrapper (using Alpine.js) -->
            <div x-data="{ activeSlide: 0, slidesCount: {{ $banners->count() }} }" x-init="setInterval(() => activeSlide = (activeSlide + 1) % slidesCount, 6000)" class="relative w-full">
                @foreach($banners as $index => $banner)
                    <div x-show="activeSlide === {{ $index }}" 
                         x-transition:enter="transition ease-out duration-700 transform"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-500 transform absolute top-0 left-0 w-full"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-8"
                         class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center"
                         style="display: none;"
                         x-bind:style="{ display: activeSlide === {{ $index }} ? 'grid' : 'none' }">
                        
                        <!-- Slide Text Content -->
                        <div class="lg:col-span-7 space-y-6">
                            <span class="inline-block px-4 py-1.5 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs font-bold tracking-widest uppercase shadow-glow">
                                <i class="fa-solid fa-leaf mr-1.5 animate-pulse"></i> TEA HOUSE SPECIAL
                            </span>
                            <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl text-white leading-tight">
                                {{ $banner->title }}
                            </h1>
                            <p class="text-base sm:text-lg text-cream/90 font-light leading-relaxed max-w-xl">
                                {{ $banner->subtitle }}
                            </p>
                            
                            <!-- Slide Action Buttons -->
                            <div class="flex flex-wrap items-center gap-4 pt-4">
                                <a href="{{ $banner->button_link ?: route('products.index') }}" class="px-8 py-4 bg-gold hover:bg-[#a67a35] text-coffee-950 font-bold rounded-2xl shadow-lg hover:scale-105 active:scale-95 transition-all text-sm tracking-wide shadow-gold/20 group">
                                    {{ $banner->button_text ?: 'EXPLORE MENU' }} <i class="fa-solid fa-arrow-right ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <a href="{{ route('custom-cake') }}" class="px-8 py-4 border border-white/20 hover:bg-white/10 text-white font-bold rounded-2xl hover:border-gold/50 transition-all text-sm tracking-wide">
                                    TEA SPECIALS <i class="fa-solid fa-mug-hot ml-1.5 text-gold"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Slide Visual Panel -->
                        <div class="lg:col-span-5 flex justify-center lg:justify-end">
                            <div class="relative w-full max-w-md">
                                <div class="absolute inset-0 bg-gradient-to-tr from-gold to-bakery-pink-200 rounded-3xl blur-2xl opacity-20"></div>
                                <div class="relative glass rounded-3xl p-4 border border-white/10 shadow-2xl overflow-hidden group">
                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full aspect-[4/3] object-cover rounded-2xl shadow-inner transition-transform duration-700 group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/fallback-hero-tea.svg') }}';">
                                    <div class="absolute bottom-6 left-6 right-6 p-4 rounded-xl bg-coffee-950/80 backdrop-blur-md border border-white/10 text-center">
                                        <p class="text-xs text-gold font-bold uppercase tracking-wider"><i class="fa-solid fa-mug-hot mr-1"></i> MANA OORU MANA TEA</p>
                                        <p class="text-sm font-semibold text-white mt-1">Brewed Fresh, Served with Love</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Slider Controls -->
                <div class="flex items-center justify-start gap-3 mt-12">
                    @foreach($banners as $index => $banner)
                        <button @click="activeSlide = {{ $index }}" class="h-2.5 rounded-full transition-all duration-300" :class="activeSlide === {{ $index }} ? 'w-8 bg-gold' : 'w-2.5 bg-white/30 hover:bg-white/50'"></button>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Fallback Static Premium Hero -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center w-full">
                <div class="space-y-8" data-aos="fade-right">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-gold/10 border border-gold/20 text-gold text-xs font-bold tracking-widest uppercase">
                        <i class="fa-solid fa-mug-hot mr-1.5 text-gold animate-pulse"></i> PREMIUM TEA LOUNGE & CAFÉ
                    </span>
                    <h1 class="font-display font-extrabold text-5xl md:text-6xl text-white leading-tight">
                        Brewed Fresh <br>
                        <span class="text-gold-gradient">Mana Ooru Mana Tea</span>
                    </h1>
                    <p class="text-base text-cream/90 font-light leading-relaxed max-w-lg">
                        Signature chai, filter coffee, café snacks, and coolers — served fresh at our Arumbaka tea lounge on NH 216.
                    </p>
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('products.index') }}" class="px-8 py-4 bg-gold hover:bg-[#a67a35] text-coffee-950 font-bold rounded-2xl shadow-lg hover:scale-105 active:scale-95 transition-all text-sm tracking-wide group">
                            EXPLORE MENU <i class="fa-solid fa-arrow-right ml-1.5 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('custom-cake') }}" class="px-8 py-4 border border-white/20 hover:bg-white/10 text-white font-bold rounded-2xl transition-all text-sm tracking-wide">
                            CUSTOM CAKES <i class="fa-solid fa-cake-candles ml-1.5 text-gold"></i>
                        </a>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-end" data-aos="fade-left">
                    <div class="relative w-full max-w-md animate-float">
                        <div class="absolute inset-0 bg-gradient-to-tr from-gold to-bakery-pink-200 rounded-3xl blur-2xl opacity-10"></div>
                        <div class="relative glass rounded-3xl p-6 border border-white/10 shadow-2xl">
                            <img src="{{ asset('images/fallback-hero-tea.svg') }}" alt="Premium chai" class="w-full aspect-[4/3] object-cover rounded-2xl mb-6 shadow" onerror="this.src='https://images.unsplash.com/photo-1571934811356-798df2168c42?q=80&w=600&auto=format&fit=crop'">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-gold font-bold uppercase tracking-wider">House Special</span>
                                <div class="flex text-amber-400 text-xs"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                            <h3 class="font-display font-bold text-xl text-white mb-2">Royal Velvet Raspberry Cake</h3>
                            <p class="text-xs text-gray-300 font-semibold mb-4 leading-relaxed">Infused with fresh raspberry coulis & layered with white chocolate cream cheese.</p>
                            <div class="flex items-center justify-between border-t border-white/10 pt-4">
                                <span class="text-xl font-bold text-gold">₹1,100</span>
                                <a href="{{ route('products.index') }}" class="px-4 py-2.5 bg-gold hover:bg-[#a67a35] text-coffee-950 rounded-xl text-xs font-bold transition-all">Order Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- 2. MODERN CATEGORY SLIDER -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <x-section-heading title="Select Premium Collections" subtitle="Indulge By Category" />

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="luxury-hover bg-white dark:bg-gray-800 rounded-3xl p-6 border border-coffee-100/5 shadow-warm text-center flex flex-col items-center group relative overflow-hidden h-full" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <!-- Decorative Subtle Background Glow -->
                <div class="absolute inset-0 bg-gradient-to-b from-gold/0 to-gold/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="w-16 h-16 rounded-full overflow-hidden mb-4 shadow border-2 border-gold/20 group-hover:scale-110 group-hover:border-gold transition-all duration-300">
                    <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/fallback-category-tea.svg') }}';">
                </div>
                
                <h3 class="font-display font-bold text-sm text-coffee-900 dark:text-white group-hover:text-gold transition-colors">{{ $cat->name }}</h3>
                <p class="text-[10px] text-coffee-500 dark:text-gray-400 mt-2 font-medium leading-relaxed flex-grow">
                    {{ Str::limit($cat->description, 45) }}
                </p>
                <div class="text-[9px] font-bold text-gold mt-4 uppercase tracking-widest flex items-center gap-1 opacity-80 group-hover:opacity-100">
                    EXPLORE <i class="fa-solid fa-chevron-right text-[7px] transition-transform group-hover:translate-x-1"></i>
                </div>
            </a>
        @endforeach
    </div>
</section>

<!-- 3. CHEF'S RECOMMENDATIONS (Featured Products Grid) -->
<section class="py-24 bg-coffee-50/40 dark:bg-gray-950/20 px-6 border-y border-coffee-100/5">
    <div class="max-w-7xl mx-auto">
        <x-section-heading title="Tea Master Picks" subtitle="Handpicked Favorites" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($chefRecommendations as $product)
                <!-- Custom decorated wrapper with TEA SPECIAL badges -->
                <div class="relative group">
                    <div class="absolute -top-3 right-4 z-20">
                        <span class="bg-gradient-to-r from-red-600 to-amber-500 text-white font-extrabold text-[10px] px-3 py-1 rounded-full shadow-lg uppercase tracking-wider border border-white/20 animate-pulse flex items-center gap-1">
                            <i class="fa-solid fa-award"></i> TEA SPECIAL
                        </span>
                    </div>
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="text-center col-span-full text-coffee-500 py-8">No special recommendations found.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- 4. HOT SELLING SAVORY ITEMS -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <x-section-heading title="Sizzling Savory Favorites" subtitle="Fresh from the Kettle" />

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
        @forelse($hotSelling as $product)
            <div class="relative">
                @if($product->is_bestseller)
                    <div class="absolute -top-3 right-4 z-20">
                        <span class="bg-amber-500 text-coffee-950 font-bold text-[9px] px-2.5 py-0.5 rounded-full shadow uppercase tracking-wide flex items-center gap-1">
                            <i class="fa-solid fa-fire text-red-600 animate-pulse"></i> BEST SELLER
                        </span>
                    </div>
                @endif
                <x-product-card :product="$product" />
            </div>
        @empty
            <p class="text-center col-span-full text-coffee-500 py-8">No hot savory products loaded.</p>
        @endforelse
    </div>
</section>

<!-- 5. SIGNATURE COMBO OFFERS -->
<section class="py-24 bg-gradient-to-r from-[#2C1810] to-[#1E0E08] text-white px-6 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/dark-wood.png')] opacity-10 pointer-events-none"></div>
    <div class="absolute -top-48 -right-48 w-96 h-96 rounded-full bg-gold/5 blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-xs font-bold text-gold uppercase tracking-widest block">EXCLUSIVELY CURATED PAIRS</span>
            <h2 class="font-display font-bold text-3xl md:text-4xl text-white pb-4 relative inline-block">
                Artisanal Combo Creations
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-16 h-0.5 bg-gold rounded-full"></span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($homepageOffers as $offer)
            <div class="rounded-3xl p-8 border border-gold/25 bg-white/95 text-coffee-900 shadow-xl flex flex-col group hover:border-gold/50 hover:scale-[1.02] transition-all duration-300">
                @if($offer->badge)<span class="text-xs text-gold font-bold uppercase tracking-wider">{{ $offer->badge }}</span>@endif
                <h3 class="font-display font-bold text-2xl text-coffee-900 mt-2">{{ $offer->title }}</h3>
                <p class="text-xs text-coffee-600 mt-3 leading-relaxed">{{ $offer->description }}</p>
                <div class="my-6 p-4 rounded-2xl bg-coffee-50 border border-coffee-100/30 flex items-center justify-between">
                    <div>
                        @if($offer->compare_price)
                        <span class="text-[10px] text-coffee-400 line-through">Regular Price: {{ $bakery['currency_symbol'] ?? '₹' }}{{ number_format($offer->compare_price, 0) }}</span>
                        @endif
                        <div class="text-2xl font-black text-gold">{{ $bakery['currency_symbol'] ?? '₹' }}{{ number_format($offer->price, 0) }}
                            @if($offer->savings)<span class="text-xs font-bold text-coffee-800">SAVE {{ $bakery['currency_symbol'] ?? '₹' }}{{ number_format($offer->savings, 0) }}</span>@endif
                        </div>
                    </div>
                    @if($offer->icon_classes)<span class="text-3xl text-gold flex gap-2">@foreach(explode(' ', $offer->icon_classes) as $icon)<i class="fa-solid {{ $icon }}"></i>@endforeach</span>@endif
                </div>
                <a href="{{ $offer->button_link ?: route('products.index') }}" class="mt-auto w-full py-3 bg-gold hover:bg-[#a67a35] text-coffee-950 font-bold rounded-xl text-center text-xs tracking-wider transition-all">{{ $offer->button_text }}</a>
            </div>
            @empty
            <p class="col-span-3 text-center text-cream/60 text-sm">Combo offers coming soon — manage them in Admin → Homepage Offers.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. SIDE-BY-SIDE BEVERAGE SHOWCASE (Premium Coffees & Mocktails) -->
<section class="py-24 bg-coffee-50/20 dark:bg-gray-950/10 border-b border-coffee-100/5 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left Column: The Espresso & Coffee Bar -->
        <div class="glass bg-white dark:bg-gray-800 rounded-3xl p-8 border border-coffee-100/5 shadow-warm flex flex-col" data-aos="fade-right">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-coffee-100/5">
                <div class="flex items-center gap-3">
                    <span class="text-3xl text-gold"><i class="fa-solid fa-mug-hot animate-bounce"></i></span>
                    <div>
                        <h3 class="font-display font-bold text-xl text-coffee-900 dark:text-white">Gourmet Coffee Bar</h3>
                        <p class="text-[10px] text-gold font-bold uppercase tracking-wider">Arabica Reserve Selection</p>
                    </div>
                </div>
                <a href="{{ route('products.index', ['category' => 'premium-coffees']) }}" class="text-xs font-bold text-gold hover:underline">VIEW FULL BAR</a>
            </div>

            <!-- Coffee Mini Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 flex-grow">
                @foreach($coffeeCollection->take(4) as $coffee)
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-coffee-50/50 dark:hover:bg-gray-700/30 transition-colors group">
                        <img src="{{ $coffee->primary_image }}" alt="{{ $coffee->name }}" class="w-14 h-14 object-cover rounded-xl border border-coffee-100/10">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-coffee-900 dark:text-white truncate group-hover:text-gold transition-colors">{{ $coffee->name }}</h4>
                            <p class="text-[10px] text-coffee-400 truncate mt-1">{{ $coffee->short_description }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs font-bold text-coffee-800 dark:text-white">₹{{ $coffee->price }}</span>
                                <button onclick="addToCartAjax({{ $coffee->id }})" class="text-[10px] font-bold text-gold hover:text-coffee-900 dark:hover:text-white flex items-center gap-1">
                                    + ADD <i class="fa-solid fa-cart-shopping text-[8px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: The Mocktail & Cooler Bar -->
        <div class="glass bg-white dark:bg-gray-800 rounded-3xl p-8 border border-coffee-100/5 shadow-warm flex flex-col" data-aos="fade-left">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-coffee-100/5">
                <div class="flex items-center gap-3">
                    <span class="text-3xl text-gold"><i class="fa-solid fa-wine-glass-empty animate-bounce"></i></span>
                    <div>
                        <h3 class="font-display font-bold text-xl text-coffee-900 dark:text-white">Vibrant Mocktail Lounge</h3>
                        <p class="text-[10px] text-gold font-bold uppercase tracking-wider">Sparkling Fresh Infusions</p>
                    </div>
                </div>
                <a href="{{ route('products.index', ['category' => 'mocktails']) }}" class="text-xs font-bold text-gold hover:underline">VIEW FULL BAR</a>
            </div>

            <!-- Mocktails Mini Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 flex-grow">
                @foreach($mocktailSpecials->take(4) as $mocktail)
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-coffee-50/50 dark:hover:bg-gray-700/30 transition-colors group">
                        <img src="{{ $mocktail->primary_image }}" alt="{{ $mocktail->name }}" class="w-14 h-14 object-cover rounded-xl border border-coffee-100/10">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-coffee-900 dark:text-white truncate group-hover:text-gold transition-colors">{{ $mocktail->name }}</h4>
                            <p class="text-[10px] text-coffee-400 truncate mt-1">{{ $mocktail->short_description }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs font-bold text-coffee-800 dark:text-white">₹{{ $mocktail->price }}</span>
                                <button onclick="addToCartAjax({{ $mocktail->id }})" class="text-[10px] font-bold text-gold hover:text-coffee-900 dark:hover:text-white flex items-center gap-1">
                                    + ADD <i class="fa-solid fa-cart-shopping text-[8px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- 7. TRENDING SWEETS & DESSERTS BOUTIQUE -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <x-section-heading title="Trending Snacks & Sweets" subtitle="Tea-Time Favorites" />

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
        @forelse($trendingDesserts as $product)
            <div class="relative">
                <div class="absolute -top-3 right-4 z-20">
                    <span class="bg-rose-500 text-white font-extrabold text-[9px] px-2.5 py-0.5 rounded-full shadow uppercase tracking-wider animate-pulse flex items-center gap-1">
                        <i class="fa-solid fa-heart"></i> POPULAR
                    </span>
                </div>
                <x-product-card :product="$product" />
            </div>
        @empty
            <p class="text-center col-span-full text-coffee-500 py-8">No trending desserts loaded.</p>
        @endforelse
    </div>
</section>

<!-- 8. ICE CREAM SUNDAE BAR -->
<section class="py-24 bg-coffee-50/40 dark:bg-gray-950/20 px-6 border-y border-coffee-100/5">
    <div class="max-w-7xl mx-auto">
        <x-section-heading title="Artisanal Ice Cream Bar" subtitle="Creamy Frozen Delights" />

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            @forelse($iceCreams->take(4) as $product)
                <div class="relative">
                    @if($product->is_bestseller)
                        <div class="absolute -top-3 right-4 z-20">
                            <span class="bg-amber-500 text-coffee-950 font-bold text-[9px] px-2.5 py-0.5 rounded-full shadow uppercase tracking-wide">
                                ⭐ FAVORITE
                            </span>
                        </div>
                    @endif
                    <x-product-card :product="$product" />
                </div>
            @empty
                <p class="text-center col-span-full text-coffee-500 py-8">No artisanal ice cream items loaded.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- 9. LATEST BLOG CHRONICLES -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <x-section-heading title="Tea Chronicles" subtitle="Stories from Our Lounge" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($latestBlogs as $blog)
            <div class="luxury-hover bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-warm border border-coffee-100/5 flex flex-col group h-full" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="relative overflow-hidden aspect-[16/10]">
                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/fallback-blog-tea.svg') }}';">
                    <span class="absolute top-4 left-4 bg-coffee-950/80 backdrop-blur-md text-gold font-bold text-[10px] px-3 py-1 rounded-full uppercase border border-white/10">{{ $blog->category ?: 'Secrets' }}</span>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <span class="text-[10px] text-coffee-400 dark:text-gray-400 font-bold uppercase tracking-wider mb-2">{{ $blog->published_at->format('M d, Y') }}</span>
                    <h4 class="font-display font-bold text-base text-coffee-900 dark:text-white leading-snug mb-3 hover:text-gold transition-colors">
                        <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                    </h4>
                    <p class="text-xs text-coffee-500 dark:text-gray-400 mb-6 font-medium line-clamp-2 leading-relaxed">
                        {{ $blog->excerpt }}
                    </p>
                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-xs font-bold text-gold hover:underline mt-auto flex items-center gap-1.5 transition-colors">
                        READ ARTICLE <i class="fa-solid fa-arrow-right text-[8px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- 10. PREMIUM TESTIMONIALS -->
<section class="py-24 bg-coffee-50/20 dark:bg-gray-950/10 border-t border-coffee-100/5 px-6">
    <div class="max-w-7xl mx-auto">
        <x-section-heading title="Loved by Tea Lovers" subtitle="Voices from Our Lounge" />

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($testimonials as $test)
                <div class="glass bg-white dark:bg-gray-800 p-8 rounded-3xl border border-coffee-100/5 shadow-warm flex flex-col relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <span class="text-gold/20 text-6xl absolute top-4 right-6 font-display leading-none">“</span>
                    <div class="flex text-amber-400 text-xs gap-0.5 mb-4">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-{{ $i <= $test->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <p class="text-xs sm:text-sm text-coffee-700 dark:text-gray-300 italic leading-relaxed mb-6 font-medium flex-grow">
                        "{{ $test->comment }}"
                    </p>
                    <div class="flex items-center gap-3 mt-auto pt-4 border-t border-coffee-100/5">
                        <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold font-bold text-sm shadow-inner border border-gold/10">
                            {{ strtoupper(substr($test->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-coffee-900 dark:text-white">{{ $test->user->name }}</h4>
                            <span class="text-[9px] text-gold font-bold uppercase tracking-wide">VERIFIED GUEST</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-coffee-500 dark:text-gray-400 text-sm py-8">Be the first to share your experience — order and leave a review!</p>
            @endforelse
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Slider dots click handlers and Alpine fallback can be handled automatically by alpinejs.
</script>
@endpush
