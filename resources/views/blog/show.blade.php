@extends('layouts.app')

@section('title', $blog->title . ' - MANA OORU MANA TEA Chronicles')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-4xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Chronicles', 'url' => route('blog.index')],
                ['label' => $blog->title, 'url' => '#']
            ]" />
        </div>

        <!-- Article Container -->
        <article class="bg-white/70 backdrop-blur-md rounded-3xl border border-amber-100 shadow-sm overflow-hidden p-8 sm:p-12">
            
            <!-- Category Tag & Date -->
            <div class="flex items-center gap-4 text-xs font-bold text-gray-400">
                <span class="rounded-full bg-gold/10 px-3 py-1 text-gold uppercase tracking-wider">{{ $blog->category }}</span>
                <span>•</span>
                <span>{{ $blog->published_at->format('F d, Y') }}</span>
            </div>

            <!-- Title -->
            <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-coffee font-playfair sm:text-4xl md:text-5xl leading-tight">
                {{ $blog->title }}
            </h1>

            <!-- Author Header -->
            <div class="mt-6 flex items-center justify-between gap-4 border-y border-amber-50 py-4 mb-8">
                <div class="flex items-center gap-3">
                    <img src="{{ $blog->author->avatar }}" class="h-10 w-10 rounded-full object-cover shadow-inner" alt="{{ $blog->author->name }}" />
                    <div>
                        <h4 class="text-xs font-bold text-coffee leading-snug">{{ $blog->author->name }}</h4>
                        <p class="text-[10px] text-gold font-bold uppercase tracking-wider">Master Pastry Chef</p>
                    </div>
                </div>

                <!-- Sharing options -->
                <div class="flex items-center gap-3 text-gray-400 text-sm">
                    <span class="text-xs font-semibold">Share:</span>
                    <button class="hover:text-gold transition"><i class="fa-brands fa-facebook"></i></button>
                    <button class="hover:text-gold transition"><i class="fa-brands fa-twitter"></i></button>
                    <button class="hover:text-gold transition"><i class="fa-brands fa-pinterest"></i></button>
                </div>
            </div>

            <!-- Header Banner Image -->
            <div class="overflow-hidden rounded-3xl border border-amber-50 shadow-md aspect-[21/10] mb-8 bg-cream/10">
                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-full object-cover" />
            </div>

            <!-- Article Body Content -->
            <div class="text-gray-700 leading-relaxed text-base space-y-6 font-playfair italic">
                {!! nl2br(e($blog->content)) !!}
            </div>

            <!-- Tags Cloud -->
            @if(is_array($blog->tags) && count($blog->tags) > 0)
                <div class="mt-12 border-t border-amber-50 pt-6">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-coffee mb-3">Topic Tags</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags as $tag)
                            <a href="{{ route('blog.index', ['search' => $tag]) }}" 
                               class="rounded-xl border border-amber-100 bg-cream/20 px-3 py-1.5 text-xs font-semibold text-coffee hover:bg-gold hover:text-cream transition">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        <!-- Recommended Related Articles -->
        @php
            $related = \App\Models\Blog::published()
                ->where('id', '!=', $blog->id)
                ->where('category', $blog->category)
                ->limit(2)
                ->get();
        @endphp
        
        @if($related->isNotEmpty())
            <div class="mt-16">
                <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair mb-6 text-center">Continue Reading</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($related as $rel)
                        <div class="group relative overflow-hidden rounded-3xl bg-white border border-amber-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between p-6">
                            <div>
                                <span class="text-[10px] font-bold text-gold uppercase tracking-wider">{{ $rel->category }}</span>
                                <h4 class="text-lg font-bold text-coffee font-playfair group-hover:text-gold transition mt-2 leading-snug">
                                    <a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h4>
                                <p class="mt-3 text-xs text-gray-600 leading-relaxed line-clamp-2">{{ $rel->excerpt }}</p>
                            </div>
                            <div class="mt-6 flex justify-between items-center border-t border-amber-50 pt-4">
                                <span class="text-[10px] text-gray-400 font-bold">{{ $rel->published_at->format('M d, Y') }}</span>
                                <a href="{{ route('blog.show', $rel->slug) }}" class="text-xs font-bold text-gold hover:underline">
                                    Read Article &nbsp;<i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
