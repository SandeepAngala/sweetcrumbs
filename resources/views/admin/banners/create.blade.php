@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.banners.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Add New Banner Slide</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Design a captivating sliding showcase for the website's landing page</p>
        </div>
    </div>

    <!-- Banner Form -->
    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Slide Main Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Crafted with Pure Love & Melted Chocolate" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="md:col-span-2">
                    <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Slide Subtitle / Description</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" placeholder="e.g. Discover our artisanal gourmet pastries hand-rolled fresh daily." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('subtitle')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image File -->
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Slide Banner Image (1920x800 recommended)</label>
                    <input type="file" name="image" id="image" required class="w-full px-4 py-2 bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 rounded-xl text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all text-sm font-semibold file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-bakery-gold-500 file:text-coffee-950 hover:file:bg-bakery-gold-600">
                    @error('image')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Display Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" required placeholder="e.g. 0, 1, 2" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('sort_order')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Text -->
                <div>
                    <label for="button_text" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">CTA Button Text (Optional)</label>
                    <input type="text" name="button_text" id="button_text" value="{{ old('button_text') }}" placeholder="e.g. Order Now" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('button_text')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Link -->
                <div>
                    <label for="button_link" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">CTA Button Link (Optional)</label>
                    <input type="text" name="button_link" id="button_link" value="{{ old('button_link') }}" placeholder="e.g. /products or https://..." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('button_link')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2 flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 rounded border-coffee-200 text-coffee-700 focus:ring-bakery-gold-400 focus:outline-none dark:bg-gray-950 dark:border-gray-800">
                    <label for="is_active" class="text-xs font-bold uppercase tracking-wider text-coffee-700 dark:text-gray-400 cursor-pointer">Active / Display Slide</label>
                    @error('is_active')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Save Slide
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
