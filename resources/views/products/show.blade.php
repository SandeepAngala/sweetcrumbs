@extends('layouts.app')

@section('title', $product->name . ' - Sweet Crumbs Boutique')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Boutique Menu', 'url' => route('products.index')],
                ['label' => $product->category->name, 'url' => route('categories.show', $product->category->slug)],
                ['label' => $product->name, 'url' => '#']
            ]" />
        </div>

        <!-- Product Presentation -->
        <div class="grid grid-cols-1 gap-x-12 gap-y-10 lg:grid-cols-2 bg-white/70 backdrop-blur-md p-8 sm:p-10 rounded-3xl border border-amber-100 shadow-sm">
            
            <!-- Left Side: Image Gallery -->
            <div class="space-y-4">
                <div class="overflow-hidden rounded-3xl border border-amber-50 shadow-md aspect-square bg-cream/20">
                    <img id="mainProductImage" src="{{ $product->primary_image }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-all duration-500 hover:scale-105" />
                </div>
                
                @if(is_array($product->images) && count($product->images) > 1)
                    <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-thin">
                        @foreach($product->images as $img)
                            <button onclick="switchProductImage('{{ $img }}')" 
                                    class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl border-2 border-amber-100 hover:border-gold shadow-sm transition">
                                <img src="{{ $img }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Side: Details & Specs -->
            <div class="flex flex-col justify-between">
                <div>
                    <!-- Category Tag -->
                    <a href="{{ route('categories.show', $product->category->slug) }}" 
                       class="inline-block rounded-full bg-gold/10 px-3 py-1 text-xs font-semibold text-gold hover:bg-gold hover:text-cream transition">
                        {{ $product->category->name }}
                    </a>

                    <!-- Product Name -->
                    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-coffee font-playfair sm:text-4xl">{{ $product->name }}</h1>

                    <!-- Ratings -->
                    <div class="mt-4 flex items-center gap-2">
                        <div class="flex text-gold gap-0.5 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-xs font-bold text-coffee">({{ $product->average_rating }} / 5.0)</span>
                        <a href="#reviews-section" class="text-xs text-gray-500 hover:text-gold transition font-semibold ml-2 underline">Read verified reviews</a>
                    </div>

                    <!-- Pricing -->
                    <div class="mt-6 flex items-baseline gap-4">
                        @if($product->discount_price)
                            <span class="text-3xl font-extrabold text-gold font-playfair">₹{{ number_format($product->discount_price, 2) }}</span>
                            <span class="text-lg text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                            <span class="rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Save {{ $product->discount_percentage }}%</span>
                        @else
                            <span class="text-3xl font-extrabold text-coffee font-playfair">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="mt-6 text-sm text-gray-600 leading-relaxed">{{ $product->short_description ?: $product->description }}</p>

                    <!-- Stock Status -->
                    <div class="mt-6 flex items-center gap-2">
                        @if($product->stock > 0)
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-semibold text-emerald-700">Freshly Baked & In Stock ({{ $product->stock }} remaining)</span>
                        @else
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                            <span class="text-xs font-semibold text-rose-700">Sold Out (Baking Fresh Tomorrow)</span>
                        @endif
                    </div>
                </div>

                <!-- Interactive CTA Actions -->
                <div class="mt-8 border-t border-amber-50 pt-6">
                    <form id="addToCartForm" onsubmit="handleDetailsAddToCart(event)" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        
                        <!-- Quantity Selector -->
                        <div class="flex items-center rounded-2xl bg-cream/50 ring-1 ring-inset ring-amber-100 w-fit p-1 shadow-sm">
                            <button type="button" onclick="decrementQty()" class="h-10 w-10 text-coffee hover:text-gold transition font-bold text-lg"><i class="fa-solid fa-minus text-xs"></i></button>
                            <input type="number" id="detailQty" name="quantity" value="1" min="1" max="{{ $product->stock ?: 10 }}" readonly
                                   class="w-12 text-center bg-transparent border-0 font-extrabold text-coffee text-sm focus:ring-0 p-0" />
                            <button type="button" onclick="incrementQty()" class="h-10 w-10 text-coffee hover:text-gold transition font-bold text-lg"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>

                        <!-- Main Buttons -->
                        <div class="flex-1 flex gap-3">
                            <button type="submit" {{ $product->stock == 0 ? 'disabled' : '' }}
                                    class="flex-1 flex justify-center items-center gap-2 rounded-2xl bg-coffee px-6 py-4 text-sm font-semibold text-cream shadow-md hover:bg-gold disabled:bg-gray-300 disabled:cursor-not-allowed hover:shadow-lg transition duration-300">
                                <i class="fa-solid fa-basket-shopping text-xs"></i> Add to Basket
                            </button>
                            
                            <button type="button" onclick="handleDetailsToggleWishlist(event, this)" 
                                    class="flex items-center justify-center h-14 w-14 rounded-2xl border border-amber-100 bg-white hover:bg-rose-50 hover:text-rose-600 shadow-sm text-gray-400 transition duration-300">
                                <i class="fa-regular fa-heart text-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Technical Specifications Tabs -->
        <div class="mt-16 bg-white/70 backdrop-blur-md rounded-3xl border border-amber-100 shadow-sm overflow-hidden">
            <div class="border-b border-amber-50">
                <nav class="flex" aria-label="Tabs">
                    <button onclick="switchTab('description')" id="tab-btn-description" class="spec-tab-btn active border-b-2 border-gold px-8 py-5 text-sm font-semibold text-coffee font-playfair hover:text-gold transition duration-300">Description & Story</button>
                    @if($product->ingredients)
                        <button onclick="switchTab('ingredients')" id="tab-btn-ingredients" class="spec-tab-btn border-b-2 border-transparent px-8 py-5 text-sm font-semibold text-gray-500 font-playfair hover:text-gold transition duration-300">Ingredients & Allergens</button>
                    @endif
                    @if(is_array($product->nutritional_info) && count($product->nutritional_info) > 0)
                        <button onclick="switchTab('nutrition')" id="tab-btn-nutrition" class="spec-tab-btn border-b-2 border-transparent px-8 py-5 text-sm font-semibold text-gray-500 font-playfair hover:text-gold transition duration-300">Nutritional Facts</button>
                    @endif
                </nav>
            </div>
            <div class="p-8 sm:p-10">
                <!-- Tab Description -->
                <div id="tab-content-description" class="spec-tab-content space-y-4 text-sm leading-6 text-gray-600">
                    <p>{{ $product->description }}</p>
                </div>
                
                <!-- Tab Ingredients -->
                @if($product->ingredients)
                    <div id="tab-content-ingredients" class="spec-tab-content space-y-4 text-sm leading-6 text-gray-600 hidden">
                        <p class="font-bold text-coffee font-playfair">What goes in:</p>
                        <p class="italic leading-relaxed">{{ $product->ingredients }}</p>
                        <div class="mt-6 rounded-2xl bg-amber-50 p-4 border border-amber-100 text-xs text-amber-800 flex gap-3 items-center">
                            <i class="fa-solid fa-circle-info text-amber-500 text-lg"></i>
                            <span>Allergy Advice: Manufactured in a bakery that processes almonds, hazelnuts, peanuts, gluten, egg and milk.</span>
                        </div>
                    </div>
                @endif

                <!-- Tab Nutrition -->
                @if(is_array($product->nutritional_info) && count($product->nutritional_info) > 0)
                    <div id="tab-content-nutrition" class="spec-tab-content hidden">
                        <div class="max-w-md overflow-hidden rounded-2xl border border-amber-100">
                            <table class="w-full text-left text-xs text-gray-500 border-collapse">
                                <thead class="bg-amber-50/50 text-coffee font-bold uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Nutrient Metric</th>
                                        <th scope="col" class="px-6 py-4">Estimated Value</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-100 bg-white">
                                    @foreach($product->nutritional_info as $key => $val)
                                        <tr class="hover:bg-cream/20 transition">
                                            <td class="px-6 py-4 font-semibold text-coffee capitalize">{{ $key }}</td>
                                            <td class="px-6 py-4 font-bold text-gold">{{ $val }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Verified Reviews Section -->
        <div id="reviews-section" class="mt-16 bg-white/70 backdrop-blur-md rounded-3xl border border-amber-100 shadow-sm p-8 sm:p-10">
            <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair mb-8">Verified Customer Reviews</h3>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Review Scores Panel -->
                <div class="bg-cream/40 p-6 rounded-3xl border border-amber-50 h-fit">
                    <div class="text-center">
                        <span class="text-5xl font-extrabold text-coffee font-playfair">{{ $product->average_rating }}</span>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-2">Average Score</p>
                        
                        <div class="mt-3 flex justify-center text-gold gap-0.5 text-lg">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Based on verified boutique reviews</p>
                    </div>
                </div>

                <!-- Review Listings -->
                <div class="lg:col-span-2 space-y-6">
                    @if($product->reviews->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-sm text-gray-600">No reviews yet for this product. Be the first to leave a sweet review!</p>
                        </div>
                    @else
                        @foreach($product->reviews as $rev)
                            <div class="border-b border-amber-50 pb-6 last:border-b-0 last:pb-0">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $rev->user->avatar ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=100&auto=format&fit=crop' }}" 
                                             class="h-10 w-10 rounded-full object-cover shadow-inner" alt="{{ $rev->user->name }}" />
                                        <div>
                                            <h4 class="text-xs font-bold text-coffee">{{ $rev->user->name }}</h4>
                                            <span class="text-[10px] text-gold font-bold uppercase tracking-wider flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check"></i> Verified Buyer
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-gray-400 font-bold">{{ $rev->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="mt-3 flex text-gold gap-0.5 text-xs">
                                    @for($i = 0; $i < $rev->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <p class="mt-3 text-sm text-gray-600 leading-relaxed font-playfair italic">"{{ $rev->comment }}"</p>
                            </div>
                        @endforeach
                    @endif

                    <!-- Review Input (requires authentication) -->
                    @auth
                        <div class="mt-12 bg-cream/20 p-6 rounded-3xl border border-amber-50">
                            <h4 class="text-sm font-bold text-coffee font-playfair mb-4">Leave a Review</h4>
                            <form action="{{ route('products.review', $product->slug) }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="flex gap-1 text-gold text-lg mb-2">
                                    <select name="rating" required class="rounded-xl border-amber-100 bg-white text-xs py-1.5 focus:ring-gold text-coffee font-bold">
                                        <option value="5">★★★★★ (5 Stars)</option>
                                        <option value="4">★★★★☆ (4 Stars)</option>
                                        <option value="3">★★★☆☆ (3 Stars)</option>
                                        <option value="2">★★☆☆☆ (2 Stars)</option>
                                        <option value="1">★☆☆☆☆ (1 Stars)</option>
                                    </select>
                                </div>
                                <div>
                                    <textarea name="comment" rows="3" required placeholder="Write your gourmet experience here..."
                                              class="w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-white focus:ring-2 focus:ring-gold text-xs"></textarea>
                                </div>
                                <button type="submit" class="rounded-xl bg-coffee px-5 py-2.5 text-xs font-semibold text-cream hover:bg-gold transition-colors duration-300">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-8 text-center bg-amber-50/50 p-4 border border-amber-100 rounded-2xl text-xs text-coffee font-semibold">
                            Please <a href="{{ route('login') }}" class="text-gold underline">login</a> to write a review.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchProductImage(imgUrl) {
        document.getElementById('mainProductImage').src = imgUrl;
    }

    function switchTab(tabId) {
        // Toggle tab buttons
        const buttons = document.querySelectorAll('.spec-tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('border-gold', 'text-coffee', 'active');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        
        const activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
        activeBtn.classList.add('border-gold', 'text-coffee', 'active');

        // Toggle tab contents
        const contents = document.querySelectorAll('.spec-tab-content');
        contents.forEach(cont => cont.classList.add('hidden'));

        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
    }

    let detailQtyVal = 1;
    function incrementQty() {
        const input = document.getElementById('detailQty');
        const max = parseInt(input.getAttribute('max'));
        if(detailQtyVal < max) {
            detailQtyVal++;
            input.value = detailQtyVal;
        }
    }

    function decrementQty() {
        const input = document.getElementById('detailQty');
        if(detailQtyVal > 1) {
            detailQtyVal--;
            input.value = detailQtyVal;
        }
    }

    function handleDetailsAddToCart(event) {
        event.preventDefault();
        
        @guest
            // Not authenticated: redirect
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        const form = event.target;
        const formData = new FormData(form);

        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Show floating notification
                showToast(data.message || 'Product successfully added to basket!', 'success');
                // Dynamically update navbar count if function exists
                if(typeof updateNavbarCartCount === 'function') {
                    updateNavbarCartCount(data.cart_count);
                }
            } else {
                showToast(data.message || 'Error occurred while adding to cart.', 'error');
            }
        })
        .catch(err => {
            showToast('Unable to reach server. Please try again.', 'error');
        });
    }

    function handleDetailsToggleWishlist(event, heartBtn) {
        @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        fetch("{{ route('wishlist.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: "{{ $product->id }}" })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showToast(data.message, 'success');
                // Toggle heart icon color
                const icon = heartBtn.querySelector('i');
                if(data.status === 'added') {
                    icon.className = "fa-solid fa-heart text-lg text-rose-600 animate-pulse";
                    heartBtn.classList.remove('text-gray-400');
                    heartBtn.classList.add('bg-rose-50', 'text-rose-600');
                } else {
                    icon.className = "fa-regular fa-heart text-lg";
                    heartBtn.classList.remove('bg-rose-50', 'text-rose-600');
                    heartBtn.classList.add('text-gray-400');
                }
            }
        })
        .catch(err => showToast('Failed to sync wishlist.', 'error'));
    }
</script>
@endsection
