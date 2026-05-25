@extends('layouts.app')

@section('title', 'Our Story - Mana Ooru Mana Tea')

@section('content')
@php
    $meta = $page?->meta ?? [];
    $established = $meta['established'] ?? '2018';
    $headline = $meta['headline'] ?? 'Where Every Cup Tells a Story';
    $subtitle = $meta['subtitle'] ?? 'South Indian chai, filter coffee & café warmth';
    $heroImage = \App\Helpers\MediaUrl::resolve($meta['hero_image'] ?? null, \App\Helpers\MediaUrl::heroFallback());
    $paragraphs = $meta['story_paragraphs'] ?? [$page?->body ?? ''];
    $values = $meta['values'] ?? [];
    $timeline = $meta['timeline'] ?? [];
@endphp
<div class="relative overflow-hidden bg-cream py-16 sm:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>
    <div class="absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-amber-50/50 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 h-[600px] w-[600px] rounded-full bg-amber-100/30 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'About Us', 'url' => '#']]" />
        </div>

        <x-section-heading
            :title="$page?->title ?? 'Our Tea Journey'"
            :subtitle="$subtitle"
            align="center"
        />

        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-center">
            <div class="relative group">
                <div class="absolute -inset-4 rounded-3xl bg-gradient-to-tr from-gold/20 to-coffee/10 opacity-30 blur-lg transition duration-500 group-hover:opacity-50"></div>
                <img src="{{ $heroImage }}" alt="{{ $headline }}" class="relative w-full aspect-[4/3] rounded-3xl object-cover shadow-2xl transition duration-500 group-hover:scale-[1.01]" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/fallback-hero-tea.svg') }}';" />
            </div>

            <div class="flex flex-col justify-center">
                <p class="text-lg font-semibold leading-8 text-gold font-playfair">Est. {{ $established }}</p>
                <h3 class="mt-2 text-3xl font-bold tracking-tight text-coffee font-playfair sm:text-4xl">{{ $headline }}</h3>
                @foreach($paragraphs as $paragraph)
                    <p class="mt-6 text-base leading-7 text-gray-600">{{ $paragraph }}</p>
                @endforeach
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('products.index') }}" class="rounded-full bg-coffee px-6 py-3 text-sm font-semibold text-cream shadow-md hover:bg-gold transition-colors duration-300">Explore Our Menu</a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold leading-6 text-coffee hover:text-gold transition-colors duration-300">Contact Our Team <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>

        @if(count($values))
        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading
                title="Our Core Philosophy"
                subtitle="The principles that guide our ovens and pastry bags every single day"
                align="center"
            />

            <dl class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach($values as $value)
                <div class="flex flex-col items-center text-center p-8 bg-white/70 backdrop-blur-md border border-amber-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <dt class="flex flex-col items-center gap-y-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gold/10 text-gold text-2xl">
                            <i class="fa-solid {{ $value['icon'] ?? 'fa-star' }}"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-coffee font-playfair">{{ $value['title'] }}</span>
                    </dt>
                    <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                        <p class="flex-auto">{{ $value['description'] }}</p>
                    </dd>
                </div>
                @endforeach
            </dl>
        </div>
        @endif

        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading
                title="Meet the Culinary Artisans"
                subtitle="The creative hands and passionate hearts behind our gorgeous creations"
                align="center"
            />

            <ul role="list" class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @forelse($team as $member)
                <li class="group">
                    <div class="relative overflow-hidden rounded-3xl aspect-[3/4] shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                             src="{{ $member->image_url }}"
                             alt="{{ $member->name }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-coffee/90 via-coffee/40 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-xl font-bold tracking-tight text-cream font-playfair">{{ $member->name }}</h3>
                            <p class="text-sm text-gold">{{ $member->role }}</p>
                            @if($member->bio)
                            <p class="mt-3 text-sm text-cream/80">{{ $member->bio }}</p>
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                <li class="col-span-3 text-center text-gray-500 py-8">Team profiles coming soon.</li>
                @endforelse
            </ul>
        </div>

        @if(count($timeline))
        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading
                title="Our Timeline"
                subtitle="The milestones of our sweet bakery adventure"
                align="center"
            />

            <div class="relative mx-auto mt-16 max-w-3xl">
                <div class="absolute left-1/2 h-full w-0.5 -translate-x-1/2 bg-gold/30"></div>

                <div class="space-y-12">
                    @foreach($timeline as $item)
                    @php $isLeft = ($item['side'] ?? 'left') === 'left'; @endphp
                    <div class="relative flex items-center justify-between group">
                        <div class="w-[45%] {{ $isLeft ? 'text-right pr-8' : '' }}">
                            @if($isLeft)
                            <span class="text-lg font-bold text-gold">{{ $item['year'] }}</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">{{ $item['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-2">{{ $item['description'] }}</p>
                            @endif
                        </div>
                        <div class="absolute left-1/2 z-10 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full {{ $loop->even ? 'bg-coffee' : 'bg-gold' }} text-cream border-4 border-cream shadow-md group-hover:scale-110 transition duration-300">
                            <i class="fa-solid {{ $item['icon'] ?? 'fa-star' }} text-xs"></i>
                        </div>
                        <div class="w-[45%] {{ $isLeft ? '' : 'text-left pl-8' }}">
                            @if(!$isLeft)
                            <span class="text-lg font-bold text-gold">{{ $item['year'] }}</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">{{ $item['title'] }}</h4>
                            <p class="text-sm text-gray-600 mt-2">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
