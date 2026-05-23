@props(['product'])

<div class="product-card group" data-aos="fade-up">

    {{-- Top Badges --}}
    <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
        @if($product->discount_price)
            <span class="inline-flex items-center gap-1 bg-rose-500/95 text-white font-bold text-[10px] px-3 py-1 rounded-full shadow-lg backdrop-blur-sm">
                <i class="fa-solid fa-tag text-[8px]"></i> {{ $product->discount_percentage }}% OFF
            </span>
        @endif
        @if($product->is_featured)
            <span class="inline-flex items-center gap-1 bg-gold/95 text-white font-bold text-[10px] px-3 py-1 rounded-full shadow-lg backdrop-blur-sm">
                <i class="fa-solid fa-star text-[8px]"></i> FEATURED
            </span>
        @endif
    </div>

    {{-- Wishlist Quick Button (top-right) --}}
    <div class="absolute top-4 right-4 z-10">
        <button onclick="toggleWishlistAjax({{ $product->id }}, this)"
                class="w-10 h-10 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110 active:scale-95"
                title="Add to Wishlist">
            @php
                $inWishlist = false;
                if (auth()->check()) {
                    $wishlistIds = \Illuminate\Support\Facades\Cache::driver('array')->remember('user_wishlist_' . auth()->id(), 60, function() {
                        return \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
                    });
                    $inWishlist = in_array($product->id, $wishlistIds);
                }
            @endphp
            <i class="{{ $inWishlist ? 'fa-solid text-rose-500' : 'fa-regular text-coffee-400' }} fa-heart text-sm"></i>
        </button>
    </div>

    {{-- Image Wrapper with Shimmer Skeleton --}}
    <div class="product-img-wrap">
        {{-- Shimmer skeleton (visible until image loads) --}}
        <div class="img-skeleton" id="skeleton-{{ $product->id }}"></div>

        <img src="{{ $product->primary_image }}"
             alt="{{ $product->name }}"
             loading="lazy"
             onload="document.getElementById('skeleton-{{ $product->id }}')?.remove()"
             onerror="this.style.display='none'; this.parentElement.querySelector('.img-skeleton')?.remove(); let f=document.createElement('div'); f.className='img-fallback w-full h-full absolute inset-0'; this.parentElement.appendChild(f);">

        {{-- Hover Quick View Overlay --}}
        <div class="product-img-overlay z-10">
            <a href="{{ route('products.show', $product->slug) }}"
               class="w-11 h-11 bg-white/95 dark:bg-gray-800/95 rounded-full flex items-center justify-center shadow-lg hover:scale-110 active:scale-95 transition-transform text-coffee-600 dark:text-gray-300"
               title="Quick View">
                <i class="fa-solid fa-eye text-sm"></i>
            </a>
        </div>
    </div>

    {{-- Product Details --}}
    <div class="p-5 sm:p-6 flex flex-col flex-grow">
        {{-- Category Label --}}
        <span class="text-[10px] text-gold font-bold uppercase tracking-[0.15em] mb-2">{{ $product->category->name }}</span>

        {{-- Product Name --}}
        <h4 class="font-display font-bold text-base sm:text-lg text-coffee-800 dark:text-white leading-snug mb-2 line-clamp-1">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-gold dark:hover:text-gold transition-colors duration-300">
                {{ $product->name }}
            </a>
        </h4>

        {{-- Star Ratings --}}
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-amber-400 text-[11px] gap-0.5">
                @php 
                    $rating = $product->reviews_avg_rating ?? $product->average_rating; 
                    $reviewsCount = $product->reviews_count ?? $product->reviews->count();
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="fa-{{ $i <= $rating ? 'solid' : 'regular' }} fa-star"></i>
                @endfor
            </div>
            <span class="text-[10px] text-coffee-400 dark:text-gray-500 font-semibold">({{ $reviewsCount }})</span>
        </div>

        {{-- Short Description --}}
        <p class="text-[11px] sm:text-xs text-coffee-500 dark:text-gray-400 leading-relaxed line-clamp-2 mb-auto font-medium">
            {{ $product->short_description ?: 'Freshly crafted using artisan methods and premium ingredients.' }}
        </p>

        {{-- Pricing & Cart Action --}}
        <div class="mt-5 pt-4 border-t border-coffee-100/10 dark:border-gray-700/30 flex items-end justify-between gap-3">
            <div class="flex flex-col gap-0.5">
                @if($product->discount_price)
                    <span class="price-original">₹{{ number_format($product->price, 0) }}</span>
                    <div class="flex items-center gap-2">
                        <span class="price-current">₹{{ number_format($product->discount_price, 0) }}</span>
                        <span class="price-badge">SAVE ₹{{ number_format($product->price - $product->discount_price, 0) }}</span>
                    </div>
                @else
                    <span class="price-current">₹{{ number_format($product->price, 0) }}</span>
                @endif
            </div>

            @auth
                <button onclick="addToCartAjax({{ $product->id }})"
                        class="btn-cart btn-premium bg-coffee-800 hover:bg-gold text-cream hover:text-white px-4 py-2.5 flex items-center gap-2 shadow-warm">
                    <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                    <span class="text-[11px] font-bold">ADD</span>
                </button>
            @else
                <a href="{{ route('login') }}"
                   class="btn-cart btn-premium border border-coffee-200 dark:border-gray-600 text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 dark:hover:bg-gray-700 px-4 py-2.5 flex items-center gap-2">
                    <i class="fa-solid fa-cart-shopping text-[10px]"></i>
                    <span class="text-[11px] font-bold">ADD</span>
                </a>
            @endauth
        </div>
    </div>
</div>
