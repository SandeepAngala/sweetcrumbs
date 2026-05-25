@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Mana Ooru Mana Tea')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'FAQ', 'url' => '#']]" />
        </div>

        <x-section-heading title="Questions? We Have Answers!" subtitle="Everything you need to know about orders, ingredients, and custom cakes" align="center" />

        <div class="mx-auto mt-16 max-w-4xl space-y-16">
            @forelse($faqs as $category => $items)
            <div>
                <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair border-b border-amber-200 pb-4 mb-6 capitalize">{{ str_replace('_', ' ', $category) }}</h3>
                <div class="space-y-4">
                    @foreach($items as $faq)
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">{{ $faq->question }}</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">{!! nl2br(e($faq->answer)) !!}</div>
                    </details>
                    @endforeach
                </div>
            </div>
            @empty
            <p class="text-center text-coffee-500">FAQs will appear here once added in Admin → FAQs.</p>
            @endforelse
        </div>

        <div class="mt-16 text-center">
            <p class="text-coffee-600 mb-4">Still have questions?</p>
            <a href="tel:{{ preg_replace('/\s+/', '', $bakery['store_phone'] ?? '') }}" class="inline-flex items-center gap-2 text-gold font-bold hover:underline">
                <i class="fa-solid fa-phone"></i> {{ $bakery['store_phone'] ?? 'Contact us' }}
            </a>
        </div>
    </div>
</div>
@endsection
