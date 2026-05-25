@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="py-12 bg-cream dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="text-center mb-12" data-aos="fade-down">
            <span class="text-xs uppercase tracking-widest font-semibold text-bakery-gold-600 dark:text-bakery-gold-400">Your Saved Sweets</span>
            <h1 class="font-display text-4xl sm:text-5xl font-extrabold text-coffee-950 dark:text-white mt-1">My Wishlist</h1>
            <div class="w-24 h-1 bg-bakery-gold-400 mx-auto mt-4 rounded-full"></div>
        </div>

        @if($wishlistItems->isEmpty())
            <!-- Empty Wishlist State -->
            <div class="max-w-md mx-auto text-center bg-white dark:bg-gray-800 rounded-3xl p-10 border border-coffee-100 dark:border-gray-700 shadow-warm" data-aos="zoom-in">
                <div class="w-20 h-20 bg-rose-50 dark:bg-rose-950/20 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500 border border-rose-100 dark:border-rose-900/50 animate-pulse">
                    <i class="fa-solid fa-heart text-3xl"></i>
                </div>
                <h2 class="font-display text-2xl font-bold text-coffee-900 dark:text-white mb-3">Your Wishlist is Empty</h2>
                <p class="text-coffee-600 dark:text-gray-300 mb-8">
                    Browse our scrumptious selection of signature cakes, pastries, cookies, and gourmet treats, and save your favorites here!
                </p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-coffee-800 text-white hover:bg-coffee-900 transition-all font-semibold shadow-warm hover:-translate-y-0.5">
                    <i class="fa-solid fa-cookie"></i> Explore Our Menu
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($wishlistItems as $item)
                    @php
                        $product = $item->product;
                        $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                        $primaryImage = $images[0] ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=600';
                    @endphp
                    
                    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-warm border border-coffee-100 dark:border-gray-700 flex flex-col group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl relative" data-aos="fade-up">
                        
                        <!-- Remove button (Floating) -->
                        <button onclick="removeFromWishlist({{ $product->id }}, this)" class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-md flex items-center justify-center text-rose-500 border border-rose-100 dark:border-rose-950/40 hover:bg-rose-500 hover:text-white transition-all shadow-md active:scale-95" title="Remove from wishlist">
                            <i class="fa-solid fa-heart-crack"></i>
                        </button>

                        <!-- Product Image -->
                        <div class="relative aspect-square w-full overflow-hidden bg-coffee-50 dark:bg-gray-950">
                            <img src="{{ $primaryImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-coffee-950/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Badges -->
                            <div class="absolute bottom-4 left-4 flex flex-col gap-1.5 z-10">
                                @if($product->is_bestseller)
                                    <span class="px-3 py-1 bg-amber-500 text-coffee-950 text-xxs font-extrabold uppercase tracking-widest rounded-full shadow-sm">Bestseller</span>
                                @endif
                                @if($product->discount_price)
                                    <span class="px-3 py-1 bg-rose-500 text-white text-xxs font-extrabold uppercase tracking-widest rounded-full shadow-sm">Sale</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content Space -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <!-- Category & Rating -->
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-bakery-gold-600 dark:text-bakery-gold-400 uppercase tracking-wider">
                                        {{ $product->category->name ?? 'House Special' }}
                                    </span>
                                    <div class="flex items-center text-amber-400 text-sm">
                                        <i class="fa-solid fa-star"></i>
                                        <span class="ml-1 text-xs font-bold text-coffee-600 dark:text-gray-400">
                                            {{ number_format($product->average_rating ?? 4.8, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Product Title -->
                                <h3 class="font-display text-xl font-bold text-coffee-900 dark:text-white mb-2 line-clamp-1 group-hover:text-bakery-gold-600 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>

                                <!-- Short description -->
                                <p class="text-sm text-coffee-500 dark:text-gray-400 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $product->short_description ?? 'A fresh, premium bakery masterpiece baked with love and finest ingredients.' }}
                                </p>
                            </div>

                            <div>
                                <!-- Pricing and Stock -->
                                <div class="flex items-baseline gap-2 mb-5">
                                    @if($product->discount_price)
                                        <span class="text-2xl font-black text-bakery-gold-600 dark:text-bakery-gold-400">₹{{ number_format($product->discount_price, 2) }}</span>
                                        <span class="text-sm text-coffee-400 dark:text-gray-500 line-through">₹{{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-2xl font-black text-coffee-900 dark:text-white">₹{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>

                                <!-- Move to Cart Form -->
                                <form action="{{ route('wishlist.move-to-cart', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3.5 px-4 bg-coffee-800 hover:bg-coffee-900 dark:bg-coffee-700 dark:hover:bg-coffee-600 text-white rounded-2xl font-bold text-sm shadow-warm flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-95 transition-all">
                                        <i class="fa-solid fa-cart-shopping"></i> Move to Cart
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    function removeFromWishlist(productId, btn) {
        if (!confirm('Are you sure you want to remove this item from your wishlist?')) return;

        // Visual feedback
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i>';

        fetch("{{ route('wishlist.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.status === 'removed') {
                window.showToast(data.message, 'success');
                // Smooth card removal
                const card = btn.closest('[data-aos="fade-up"]');
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    card.remove();
                    // If no cards left, reload to show empty state
                    if (document.querySelectorAll('[data-aos="fade-up"]').length === 0) {
                        window.location.reload();
                    }
                }, 300);
            } else {
                window.showToast('Something went wrong. Please try again.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-heart-crack"></i>';
            }
        })
        .catch(err => {
            console.error(err);
            window.showToast('Failed to contact server.', 'error');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-heart-crack"></i>';
        });
    }
</script>
@endpush
