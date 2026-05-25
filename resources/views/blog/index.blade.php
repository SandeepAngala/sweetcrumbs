@extends('layouts.app')

@section('title', 'MANA OORU MANA TEA Blog - Sourdough Secrets & Pastry Science')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Baking Blog & Science', 'url' => '#']]" />
        </div>

        <x-section-heading 
            title="The Sweet Chronicles" 
            subtitle="Deep dives into natural slow lamination, sourdough ecosystems, and gourmet baking science"
            align="center"
        />

        <!-- Blog Page Layout -->
        <div class="mt-12 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            
            <!-- Sidebar Panel (Filters & Search) -->
            <div class="space-y-8 lg:col-span-1">
                <!-- Search -->
                <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-amber-100 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-coffee font-playfair border-b border-amber-50 pb-2 mb-4">Search Articles</h3>
                    <form action="{{ route('blog.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Sourdough, flour..."
                               class="w-full rounded-xl border-0 bg-cream/30 py-2.5 pl-4 pr-10 text-xs text-gray-900 ring-1 ring-inset ring-amber-100 focus:ring-2 focus:ring-gold" />
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gold">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Categories -->
                <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-amber-100 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-coffee font-playfair border-b border-amber-50 pb-2 mb-4">Categories</h3>
                    <ul class="space-y-3 text-xs font-medium text-gray-700">
                        <li>
                            <a href="{{ route('blog.index') }}" class="flex justify-between items-center hover:text-gold transition {{ !request('category') ? 'text-gold font-bold' : '' }}">
                                <span>All Articles</span>
                                <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] text-coffee border border-amber-100">{{ \App\Models\Blog::published()->count() }}</span>
                            </a>
                        </li>
                        @php
                            $cats = \App\Models\Blog::published()->select('category', \DB::raw('count(*) as count'))->groupBy('category')->get();
                        @endphp
                        @foreach($cats as $c)
                            <li>
                                <a href="{{ route('blog.index', ['category' => $c->category]) }}" class="flex justify-between items-center hover:text-gold transition {{ request('category') === $c->category ? 'text-gold font-bold' : '' }}">
                                    <span>{{ $c->category }}</span>
                                    <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] text-coffee border border-amber-100">{{ $c->count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Articles Grid Area (Right Panels) -->
            <div class="lg:col-span-3 space-y-10">
                @if($blogs->isEmpty())
                    <div class="text-center py-20 bg-white/70 backdrop-blur-md rounded-3xl border border-amber-100 shadow-sm">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-amber-50 text-gold text-2xl mx-auto">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h3 class="mt-4 text-xl font-bold tracking-tight text-coffee font-playfair">No baking chronicles found</h3>
                        <p class="mt-2 text-sm text-gray-600">Try adjusting your search keyword or categories.</p>
                        <div class="mt-6">
                            <a href="{{ route('blog.index') }}" class="rounded-full bg-coffee px-6 py-3 text-xs font-semibold text-cream shadow-sm hover:bg-gold transition-colors duration-300">Show All Articles</a>
                        </div>
                    </div>
                @else
                    <!-- Featured Article Card (if first page and no search/category selected) -->
                    @if($blogs->currentPage() === 1 && !request('search') && !request('category'))
                        @php $featured = $blogs->first(); @endphp
                        <div class="group relative overflow-hidden rounded-3xl bg-white border border-amber-100 shadow-sm hover:shadow-xl transition-all duration-500 grid grid-cols-1 md:grid-cols-2">
                            <!-- Image -->
                            <div class="relative overflow-hidden h-[250px] md:h-full bg-cream/10">
                                <img src="{{ $featured->image }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.01]" />
                            </div>
                            <!-- Content -->
                            <div class="p-8 flex flex-col justify-between">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 text-[10px] font-bold text-gray-400">
                                        <span class="rounded-full bg-gold/10 px-2.5 py-0.5 text-gold">{{ $featured->category }}</span>
                                        <span>•</span>
                                        <span>{{ $featured->published_at->format('M d, Y') }}</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-coffee font-playfair group-hover:text-gold transition leading-tight">
                                        <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-600 leading-relaxed">{{ $featured->excerpt }}</p>
                                </div>
                                <div class="mt-8 flex justify-between items-center border-t border-amber-50 pt-4">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $featured->author->avatar }}" class="h-7 w-7 rounded-full object-cover shadow-inner" />
                                        <span class="text-[10px] font-bold text-coffee">{{ $featured->author->name }}</span>
                                    </div>
                                    <a href="{{ route('blog.show', $featured->slug) }}" class="text-xs font-bold text-gold hover:underline flex items-center gap-1">
                                        Read Article &nbsp;<i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Secondary Articles Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @foreach($blogs as $index => $blog)
                            <!-- Skip featured in grid if default view -->
                            @if($blogs->currentPage() === 1 && !request('search') && !request('category') && $index === 0)
                                @continue
                            @endif
                            
                            <div class="group relative overflow-hidden rounded-3xl bg-white border border-amber-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                                <div>
                                    <!-- Image -->
                                    <div class="relative overflow-hidden aspect-[16/10] bg-cream/10">
                                        <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.01]" />
                                        <span class="absolute top-4 left-4 rounded-xl bg-gold/90 backdrop-blur-sm px-2.5 py-1 text-[10px] font-bold text-cream shadow-sm">
                                            {{ $blog->category }}
                                        </span>
                                    </div>
                                    
                                    <!-- Details -->
                                    <div class="p-6">
                                        <span class="text-[10px] font-bold text-gray-400">{{ $blog->published_at->format('M d, Y') }}</span>
                                        <h4 class="mt-2 text-lg font-bold text-coffee font-playfair group-hover:text-gold transition leading-snug">
                                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                        </h4>
                                        <p class="mt-3 text-xs text-gray-600 leading-relaxed line-clamp-3">{{ $blog->excerpt }}</p>
                                    </div>
                                </div>

                                <div class="px-6 pb-6 pt-2 flex justify-between items-center border-t border-amber-50">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $blog->author->avatar }}" class="h-6 w-6 rounded-full object-cover shadow-inner" />
                                        <span class="text-[10px] font-bold text-coffee">{{ $blog->author->name }}</span>
                                    </div>
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="text-xs font-bold text-gold hover:underline flex items-center gap-1">
                                        Read &nbsp;<i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center pt-8">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
