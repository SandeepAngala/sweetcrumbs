@extends('layouts.app')

@section('title', 'MANA OORU MANA TEA Boutique Menu - Handcrafted Pastries')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Boutique Menu', 'url' => '#']]" />
        </div>

        <x-section-heading 
            title="Our Gourmet Boutique Menu" 
            subtitle="Indulge in our collection of freshly baked goods and delicate masterpieces"
            align="center"
        />

        <!-- Main Product Grid & Sidebar Filters -->
        <div class="mt-12 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            
            <!-- Side Filter Sidebar (Left Panel) -->
            <form action="{{ route('products.index') }}" method="GET" class="space-y-6 bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-amber-100 shadow-sm h-fit">
                <div>
                    <h3 class="text-base font-bold text-coffee font-playfair border-b border-amber-50 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-gold text-sm"></i> Filters
                    </h3>
                </div>

                <!-- Search inside sidebar -->
                <div>
                    <label for="search" class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Search Products</label>
                    <div class="mt-2 relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Chai, coffee, snacks..."
                               class="w-full rounded-xl border-0 bg-cream/30 py-2.5 pl-4 pr-10 text-xs text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 focus:ring-2 focus:ring-gold" />
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gold">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Category Filters -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Category</label>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <input type="radio" id="cat-all" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()"
                                   class="h-4 w-4 border-amber-100 text-gold focus:ring-gold" />
                            <label for="cat-all" class="ml-2 cursor-pointer font-medium hover:text-gold transition">All Specialties</label>
                        </div>
                        @foreach($categories as $cat)
                            <div class="flex items-center text-xs text-gray-700">
                                <input type="radio" id="cat-{{ $cat->id }}" name="category" value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'checked' : '' }} onchange="this.form.submit()"
                                       class="h-4 w-4 border-amber-100 text-gold focus:ring-gold" />
                                <label for="cat-{{ $cat->id }}" class="ml-2 cursor-pointer font-medium hover:text-gold transition">{{ $cat->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Slider (Min/Max Fields) -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Price Range</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min"
                                   class="w-full rounded-xl border-0 bg-cream/30 px-3 py-2 text-xs text-gray-900 ring-1 ring-inset ring-amber-100 focus:ring-2 focus:ring-gold" />
                        </div>
                        <div>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max"
                                   class="w-full rounded-xl border-0 bg-cream/30 px-3 py-2 text-xs text-gray-900 ring-1 ring-inset ring-amber-100 focus:ring-2 focus:ring-gold" />
                        </div>
                    </div>
                    <button type="submit" class="mt-3 w-full rounded-xl bg-amber-50 py-2 text-[10px] font-bold text-coffee border border-amber-100 hover:bg-gold hover:text-cream transition-colors duration-300">Apply range</button>
                </div>

                <!-- Sorting Selection -->
                <div>
                    <label for="sort" class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Sort By</label>
                    <select name="sort" id="sort" onchange="this.form.submit()"
                            class="mt-2 block w-full rounded-xl border-0 bg-cream/30 px-3 py-2.5 text-xs text-gray-900 ring-1 ring-inset ring-amber-100 focus:ring-2 focus:ring-gold">
                        <option value="featured" {{ request('sort') === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                    </select>
                </div>

                <!-- Reset Button -->
                @if(request()->anyFilled(['search', 'category', 'price_min', 'price_max', 'sort']))
                    <div>
                        <a href="{{ route('products.index') }}" 
                           class="block text-center w-full rounded-xl border border-rose-100 bg-rose-50 py-2.5 text-xs font-bold text-rose-700 hover:bg-rose-100 transition-colors duration-300">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </form>

            <!-- Product Grid Area (Right Panels) -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-20 bg-white/70 backdrop-blur-md rounded-3xl border border-amber-100 shadow-sm">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-50 text-gold text-2xl mx-auto">
                            <i class="fa-solid fa-wheat-awn-slash"></i>
                        </div>
                        <h3 class="mt-4 text-xl font-bold tracking-tight text-coffee font-playfair">No gourmet delights found</h3>
                        <p class="mt-2 text-sm text-gray-600">Try loosening your search terms or adjustments of filter scopes.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="rounded-full bg-coffee px-6 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Clear All Filters</a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Custom Beautiful Pagination -->
                    <div class="mt-12 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
