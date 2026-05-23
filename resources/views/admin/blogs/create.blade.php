@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.blogs.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Write New Article</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Publish recipes, baking guides, and boutique stories to inspire your customers</p>
        </div>
    </div>

    <!-- Blog Form -->
    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Blog Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Article Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. 5 Secrets to the Perfect Flaky Sourdough Crust" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Category / Tag</label>
                    <select name="category" id="category" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-semibold">
                        <option value="Baking Guides" {{ old('category') == 'Baking Guides' ? 'selected' : '' }}>Baking Guides</option>
                        <option value="Recipes" {{ old('category') == 'Recipes' ? 'selected' : '' }}>Recipes</option>
                        <option value="Boutique Stories" {{ old('category') == 'Boutique Stories' ? 'selected' : '' }}>Boutique Stories</option>
                        <option value="Chef Chronicles" {{ old('category') == 'Chef Chronicles' ? 'selected' : '' }}>Chef Chronicles</option>
                        <option value="Event Catering" {{ old('category') == 'Event Catering' ? 'selected' : '' }}>Event Catering</option>
                    </select>
                    @error('category')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Cover Image</label>
                    <input type="file" name="image" id="image" class="w-full px-4 py-2 bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 rounded-xl text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all text-sm font-semibold file:mr-4 file:py-1.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-bakery-gold-500 file:text-coffee-950 hover:file:bg-bakery-gold-600">
                    @error('image')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt / Short Snippet -->
                <div class="md:col-span-2">
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Short Excerpt (Brief overview snippet, max 500 chars)</label>
                    <input type="text" name="excerpt" id="excerpt" value="{{ old('excerpt') }}" placeholder="An easy, comprehensive walkthrough detailing flour composition, fermentation, and scoring techniques..." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium">
                    @error('excerpt')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="md:col-span-2">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Article Body / Content</label>
                    <textarea name="content" id="content" rows="12" required placeholder="Write your baking masterclass, instructions, or bakery story here. Use paragraphs or clear formatting..." class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 transition-all font-medium resize-none">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publish Status -->
                <div class="md:col-span-2 flex items-center gap-3">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="w-5 h-5 rounded border-coffee-200 text-coffee-700 focus:ring-bakery-gold-400 focus:outline-none dark:bg-gray-950 dark:border-gray-800">
                    <label for="is_published" class="text-xs font-bold uppercase tracking-wider text-coffee-700 dark:text-gray-400 cursor-pointer">Publish Immediately</label>
                    @error('is_published')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.blogs.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Save Article
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
