@extends('layouts.app')

@section('title', 'Customer Testimonials - MANA OORU MANA TEA Reviews')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Testimonials', 'url' => '#']]" />
        </div>

        <x-section-heading
            title="Loved by Tea Lovers"
            subtitle="Real stories from guests at our NH 216 tea lounge"
            align="center"
        />

        @if(session('success'))
            <div class="mx-auto max-w-2xl mt-8 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-emerald-800 text-sm text-center">
                <i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            @forelse($reviews as $review)
            <div class="flex flex-col justify-between bg-white/70 backdrop-blur-sm border border-amber-100 p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <div class="flex gap-1 text-gold">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <blockquote class="mt-6 text-base text-gray-600 leading-relaxed font-playfair italic">
                        "{{ $review->comment }}"
                    </blockquote>
                </div>
                <div class="mt-8 flex items-center gap-x-4 border-t border-amber-50 pt-6">
                    <div class="h-12 w-12 rounded-full bg-gold/20 flex items-center justify-center text-gold font-bold text-lg shadow-inner">
                        {{ strtoupper(substr($review->user->name ?? 'G', 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-coffee">{{ $review->user->name ?? 'Guest' }}</h4>
                        <p class="text-xs text-gold font-semibold">
                            @if($review->is_verified_purchase) Verified Purchase @else Customer Review @endif
                            @if($review->product) · {{ $review->product->name }} @endif
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-500 py-12">No reviews yet. Be the first to share your tea lounge experience!</p>
            @endforelse
        </div>

        @if($reviews->hasPages())
        <div class="mt-12">{{ $reviews->links() }}</div>
        @endif

        @auth
        <div class="mx-auto mt-24 max-w-2xl bg-white/80 backdrop-blur-md border border-amber-100 p-8 sm:p-10 rounded-3xl shadow-xl">
            <h3 class="text-xl font-bold tracking-tight text-coffee font-playfair text-center mb-2">Share Your Sweet Experience</h3>
            <p class="text-sm text-gray-600 text-center mb-8">Your feedback inspires our pastry chefs and helps other dessert lovers choose.</p>

            <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="product_id" class="block text-sm font-semibold leading-6 text-coffee">Product Reviewed</label>
                    <select name="product_id" id="product_id" required class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">
                        <option value="">Select a product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold leading-6 text-coffee text-center">Your Rating</label>
                    <div class="mt-3 flex justify-center gap-2 text-2xl text-amber-200" id="star-picker">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-rating="{{ $i }}" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="selectedRating" value="{{ old('rating', 5) }}" />
                    @error('rating')<p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-semibold leading-6 text-coffee">Your Review</label>
                    <textarea name="comment" id="comment" rows="4" required placeholder="Tell us about the texture, flavors, and our boutique service..."
                              class="mt-2 block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm">{{ old('comment') }}</textarea>
                    @error('comment')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full rounded-2xl bg-coffee px-6 py-4 text-center text-sm font-semibold text-cream shadow-md hover:bg-gold transition-colors duration-300">
                    Submit Review &nbsp;<i class="fa-solid fa-heart"></i>
                </button>
            </form>
        </div>
        @else
        <div class="mx-auto mt-24 max-w-2xl text-center bg-white/80 backdrop-blur-md border border-amber-100 p-8 rounded-3xl shadow-xl">
            <p class="text-gray-600 mb-4">Sign in to share your experience with our community.</p>
            <a href="{{ route('login') }}" class="inline-block rounded-2xl bg-coffee px-6 py-3 text-sm font-semibold text-cream hover:bg-gold transition-colors">Sign In to Review</a>
        </div>
        @endauth
    </div>
</div>

@auth
<script>
    function setRating(rating) {
        document.getElementById('selectedRating').value = rating;
        document.querySelectorAll('.star-btn').forEach((star, index) => {
            star.classList.toggle('text-gold', index < rating);
            star.classList.toggle('text-amber-200', index >= rating);
        });
    }
    document.addEventListener('DOMContentLoaded', () => {
        setRating(parseInt(document.getElementById('selectedRating').value) || 5);
        document.querySelectorAll('.star-btn').forEach(btn => {
            btn.addEventListener('click', () => setRating(parseInt(btn.dataset.rating)));
        });
    });
</script>
@endauth
@endsection
