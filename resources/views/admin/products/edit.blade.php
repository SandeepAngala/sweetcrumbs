@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.products.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Edit Product</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Refine and update details for "{{ $product->name }}"</p>
        </div>
    </div>

    <!-- Product Form -->
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Menu Category</label>
                    <select name="category_id" id="category_id" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-semibold">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Inventory Status</label>
                    <select name="status" id="status" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-semibold">
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="draft" {{ old('status', $product->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Original Price (₹)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discount Price -->
                <div>
                    <label for="discount_price" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Discount Price (₹, Optional)</label>
                    <input type="number" step="0.01" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('discount_price')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Stock Quantity</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('stock')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Images -->
                <div>
                    <label for="images" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Change Dessert Photos (Will overwrite existing)</label>
                    <input type="file" name="images[]" id="images" multiple class="w-full px-4 py-2.5 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all text-sm font-semibold file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-bakery-gold-500 file:text-coffee-950 hover:file:bg-bakery-gold-600">
                    @error('images')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Image Previews -->
                <div class="md:col-span-2">
                    <span class="block text-xs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-3">Current Photos</span>
                    <div class="flex gap-4">
                        @php
                            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                        @endphp
                        @foreach($images ?? [] as $img)
                            <img src="{{ $img }}" alt="Preview" class="w-20 h-20 object-cover rounded-xl border border-coffee-100 dark:border-gray-700 shadow-sm">
                        @endforeach
                    </div>
                </div>

                <!-- Toggles for Tags / Badges -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-coffee-50 dark:border-gray-800">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-coffee-200 text-bakery-gold-600 focus:ring-bakery-gold-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-coffee-700 dark:text-gray-300">Feature on Home</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_trending" value="1" {{ old('is_trending', $product->is_trending) ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-coffee-200 text-bakery-gold-600 focus:ring-bakery-gold-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-coffee-700 dark:text-gray-300">Trending Badge</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} class="w-5 h-5 rounded-lg border-coffee-200 text-bakery-gold-600 focus:ring-bakery-gold-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-coffee-700 dark:text-gray-300">Bestseller Badge</span>
                    </label>
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Short Description (Snippet, max 255 characters)</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('short_description')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Full Description & Ingredients</label>
                    <textarea name="description" id="description" rows="5" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium resize-none">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Save Changes
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
