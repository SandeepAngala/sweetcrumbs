@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.categories.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Edit Category</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Update details for category "{{ $category->name }}"</p>
        </div>
    </div>

    <!-- Category Form -->
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <!-- Category Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                @error('sort_order')
                    <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Cover Image -->
            <div>
                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Change Cover Image</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2.5 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all text-sm font-semibold file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-bakery-gold-500 file:text-coffee-950 hover:file:bg-bakery-gold-600">
                @error('image')
                    <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image Preview -->
            @if($category->image)
                <div>
                    <span class="block text-xs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-2">Current Cover</span>
                    <img src="{{ $category->image }}" alt="Category Cover" class="w-28 h-20 object-cover rounded-xl border border-coffee-100 dark:border-gray-700 shadow-sm">
                </div>
            @endif

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium resize-none">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Is Active checkbox -->
            <div class="flex items-center pt-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-coffee-100 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-bakery-gold-500"></div>
                    <span class="ml-3 text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400">Category Active on Shop Menu</span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
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
