@extends('layouts.app')

@section('title', 'Browse Specialties by Category - Sweet Crumbs Bakery')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Specialty Categories', 'url' => '#']]" />
        </div>

        <!-- Heading -->
        <x-section-heading 
            title="Gourmet Specialty Categories" 
            subtitle="Browse our carefully cataloged collections of artisanal bakery delights"
            align="center"
        />

        <!-- Category Grid -->
        <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($categories as $cat)
                <div class="group relative overflow-hidden rounded-3xl bg-white border border-amber-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between">
                    <div>
                        <!-- Image wrapper -->
                        <div class="relative overflow-hidden aspect-[16/10] bg-cream/10">
                            <img src="{{ $cat->image ?: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=600&auto=format&fit=crop' }}" 
                                 alt="{{ $cat->name }}" 
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                            
                            <!-- Product count badge floating -->
                            <div class="absolute top-4 right-4 rounded-xl bg-coffee/80 backdrop-blur-md px-3 py-1.5 text-xs font-bold text-cream shadow-sm">
                                {{ $cat->products_count }} Products
                            </div>
                        </div>

                        <!-- Info details -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-coffee font-playfair group-hover:text-gold transition">
                                <a href="{{ route('categories.show', $cat->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $cat->name }}
                                </a>
                            </h3>
                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ $cat->description }}</p>
                        </div>
                    </div>

                    <!-- Footer browse link -->
                    <div class="px-6 pb-6 pt-2">
                        <span class="text-xs font-bold text-gold flex items-center gap-1 group-hover:gap-2 transition-all duration-300">
                            Browse Products &nbsp;<i class="fa-solid fa-arrow-right"></i>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
