@extends('layouts.app')

@section('title', 'Customer Testimonials - Sweet Crumbs Reviews')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <!-- Decorative backgrounds -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Testimonials', 'url' => '#']]" />
        </div>

        <!-- Heading -->
        <x-section-heading 
            title="Loved by Sweet Lovers" 
            subtitle="Read glowing stories from our lovely customers and professional food critics"
            align="center"
        />

        <!-- Reviews Grid -->
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <!-- Review 1 -->
            <div class="flex flex-col justify-between bg-white/70 backdrop-blur-sm border border-amber-100 p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <!-- Stars -->
                    <div class="flex gap-1 text-gold">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <blockquote class="mt-6 text-base text-gray-600 leading-relaxed font-playfair italic">
                        "The Royal Velvet raspberry cake was the absolute star of my daughter's birthday. It was incredibly moist, and that hint of fresh raspberry coulis combined with luxury white chocolate frosting was sheer perfection. Chef Sandeep is a true artist!"
                    </blockquote>
                </div>
                <div class="mt-8 flex items-center gap-x-4 border-t border-amber-50 pt-6">
                    <img class="h-12 w-12 rounded-full object-cover shadow-inner" src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150&auto=format&fit=crop" alt="Sophia Carter">
                    <div>
                        <h4 class="text-sm font-bold text-coffee">Sophia Carter</h4>
                        <p class="text-xs text-gold font-semibold">Verified Customer</p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="flex flex-col justify-between bg-white/70 backdrop-blur-sm border border-amber-100 p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <!-- Stars -->
                    <div class="flex gap-1 text-gold">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <blockquote class="mt-6 text-base text-gray-600 leading-relaxed font-playfair italic">
                        "As a culinary critic, I am extremely picky about French lamination. The butter croissants at Sweet Crumbs are, without a doubt, the most authentic in the city. The crumb honeycomb interior is light, airy, and extraordinarily buttery. Phenomenal."
                    </blockquote>
                </div>
                <div class="mt-8 flex items-center gap-x-4 border-t border-amber-50 pt-6">
                    <img class="h-12 w-12 rounded-full object-cover shadow-inner" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop" alt="Vikram Malhotra">
                    <div>
                        <h4 class="text-sm font-bold text-coffee">Vikram Malhotra</h4>
                        <p class="text-xs text-gold font-semibold">Food Columnist, Daily Gourmet</p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="flex flex-col justify-between bg-white/70 backdrop-blur-sm border border-amber-100 p-8 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <!-- Stars -->
                    <div class="flex gap-1 text-gold">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <blockquote class="mt-6 text-base text-gray-600 leading-relaxed font-playfair italic">
                        "Finding delicious gluten-free bakery items is almost impossible, but Sweet Crumbs has totally solved this. The Gluten-Free Almond Orange Cake is moist, perfectly sweet, and absolutely healthy. A weekly staple for my family!"
                    </blockquote>
                </div>
                <div class="mt-8 flex items-center gap-x-4 border-t border-amber-50 pt-6">
                    <img class="h-12 w-12 rounded-full object-cover shadow-inner" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=150&auto=format&fit=crop" alt="Emma Watson">
                    <div>
                        <h4 class="text-sm font-bold text-coffee">Emma Watson</h4>
                        <p class="text-xs text-gold font-semibold">Verified Customer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inline Review Submission Form -->
        <div class="mx-auto mt-24 max-w-2xl bg-white/80 backdrop-blur-md border border-amber-100 p-8 sm:p-10 rounded-3xl shadow-xl">
            <h3 class="text-xl font-bold tracking-tight text-coffee font-playfair text-center mb-2">Share Your Sweet Experience</h3>
            <p class="text-sm text-gray-600 text-center mb-8">Your feedback inspires our pastry chefs and helps other dessert lovers choose.</p>
            
            <form onsubmit="submitReview(event)" class="space-y-6">
                <!-- Star Rating Picker -->
                <div>
                    <label class="block text-sm font-semibold leading-6 text-coffee text-center">Your Rating</label>
                    <div class="mt-3 flex justify-center gap-2 text-2xl text-amber-200">
                        <button type="button" onclick="setRating(1)" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                        <button type="button" onclick="setRating(2)" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                        <button type="button" onclick="setRating(3)" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                        <button type="button" onclick="setRating(4)" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                        <button type="button" onclick="setRating(5)" class="star-btn transition duration-200 hover:scale-110"><i class="fa-solid fa-star"></i></button>
                    </div>
                    <input type="hidden" id="selectedRating" name="rating" value="5" />
                </div>

                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold leading-6 text-coffee">Your Name</label>
                        <div class="mt-2">
                            <input type="text" id="name" required class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                    </div>
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold leading-6 text-coffee">Email Address</label>
                        <div class="mt-2">
                            <input type="email" id="email" required class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm" />
                        </div>
                    </div>
                    <!-- Review Content -->
                    <div class="sm:col-span-2">
                        <label for="review" class="block text-sm font-semibold leading-6 text-coffee">Your Review</label>
                        <div class="mt-2">
                            <textarea id="review" rows="4" required placeholder="Tell us about the texture, flavors, and our boutique service..." class="block w-full rounded-2xl border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-amber-100 bg-cream/30 focus:ring-2 focus:ring-gold text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full rounded-2xl bg-coffee px-6 py-4 text-center text-sm font-semibold text-cream shadow-md hover:bg-gold transition-colors duration-300">
                        Submit Review &nbsp;<i class="fa-solid fa-heart"></i>
                    </button>
                </div>
            </form>
            
            <!-- Success message placeholder -->
            <div id="reviewSuccess" class="hidden mt-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-emerald-800 text-sm text-center">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg mr-2"></i>
                <span>Thank you! Your review has been submitted for chef moderation and will appear soon.</span>
            </div>
        </div>
    </div>
</div>

<script>
    let currentRating = 5;

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('selectedRating').value = rating;
        const stars = document.querySelectorAll('.star-btn');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-amber-200');
                star.classList.add('text-gold');
            } else {
                star.classList.remove('text-gold');
                star.classList.add('text-amber-200');
            }
        });
    }

    // Initialize rating stars as gold
    document.addEventListener('DOMContentLoaded', () => {
        setRating(5);
    });

    function submitReview(event) {
        event.preventDefault();
        // Hide form, show success
        event.currentTarget.classList.add('hidden');
        document.getElementById('reviewSuccess').classList.remove('hidden');
    }
</script>
@endsection
