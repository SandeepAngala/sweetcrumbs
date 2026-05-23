@extends('layouts.app')

@section('title', 'Frequently Asked Questions - Sweet Crumbs Bakery')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <!-- Background styling -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>
    
    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'FAQ', 'url' => '#']]" />
        </div>

        <!-- Heading -->
        <x-section-heading 
            title="Questions? We Have Answers!" 
            subtitle="Everything you need to know about our orders, ingredients, and custom cakes"
            align="center"
        />

        <div class="mx-auto mt-16 max-w-4xl space-y-16">
            <!-- Ordering & Delivery Category -->
            <div>
                <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair border-b border-amber-200 pb-4 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-truck-fast text-gold"></i> Ordering & Delivery
                </h3>
                
                <div class="space-y-4">
                    <!-- Q1 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">What are your delivery zones and fees?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            We deliver to all locations within a 15km radius of our central Connaught Place boutique. Delivery is absolutely free for all orders above ₹500. For orders below ₹500, a flat fee of ₹50 is charged. You can view delivery availability at checkout.
                        </div>
                    </details>

                    <!-- Q2 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">How far in advance should I place my order?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            For standard menu products (breads, pastries, signature cupcakes, standard cakes), orders placed before 8:00 PM are eligible for next-day morning delivery. Same-day delivery is available for select pre-baked items in our "Ready to Pick" section if ordered before 2:00 PM.
                        </div>
                    </details>
                </div>
            </div>

            <!-- Custom Cakes Category -->
            <div>
                <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair border-b border-amber-200 pb-4 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-cake-candles text-gold"></i> Custom Celebration Cakes
                </h3>
                
                <div class="space-y-4">
                    <!-- Q1 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">How do I order a custom wedding or birthday cake?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            You can easily sketch and request a custom cake using our digital <a href="{{ route('custom-cake') }}" class="text-gold font-bold hover:underline">Custom Cake Builder</a>. Select your layers, base flavors, fillings, and special design motifs. Once submitted, our artisanal chefs will review it and send an instant quote or contact you for a 1-on-1 design alignment.
                        </div>
                    </details>

                    <!-- Q2 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">How much lead time is needed for custom orders?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            We require at least 3-5 days lead time for custom birthday cakes, and at least 2-3 weeks for elaborate multi-tier wedding cakes. This ensures our chefs can source fresh organic ingredients and spend the necessary hours detailing sugar ornaments.
                        </div>
                    </details>
                </div>
            </div>

            <!-- Dietary Needs Category -->
            <div>
                <h3 class="text-2xl font-bold tracking-tight text-coffee font-playfair border-b border-amber-200 pb-4 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-seedling text-gold"></i> Dietary & Ingredients
                </h3>
                
                <div class="space-y-4">
                    <!-- Q1 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">Do you offer Gluten-Free and Eggless options?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            Yes! We have a dedicated <a href="/categories/gluten-free-vegan" class="text-gold font-bold hover:underline">Gluten-Free & Vegan</a> menu category. Almost all our signature cakes can also be ordered in pure eggless configurations upon request in the cake product options.
                        </div>
                    </details>

                    <!-- Q2 -->
                    <details class="group bg-white/70 backdrop-blur-sm border border-amber-100 rounded-2xl shadow-sm [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex cursor-pointer items-center justify-between gap-1.5 p-6 text-coffee font-semibold">
                            <h4 class="text-base font-bold">Are your kitchens nut-free?</h4>
                            <span class="relative h-5 w-5 shrink-0">
                                <i class="fa-solid fa-plus absolute inset-0 text-gold group-open:opacity-0 transition duration-300"></i>
                                <i class="fa-solid fa-minus absolute inset-0 text-gold opacity-0 group-open:opacity-100 transition duration-300"></i>
                            </span>
                        </summary>
                        <div class="px-6 pb-6 text-sm leading-6 text-gray-600 border-t border-amber-50 pt-4">
                            No. While we sterilize all preparation areas and isolate utensils for nut-free recipes, we use peanuts, walnuts, almonds, and pistachios daily in our bakery. Cross-contact is possible, so we do not recommend our pastries for individuals with severe, life-threatening nut allergies.
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 text-center">
            <h4 class="text-lg font-bold text-coffee font-playfair">Still have a question?</h4>
            <p class="mt-2 text-sm text-gray-600">Our customer happiness team is here to help you get answers.</p>
            <div class="mt-6 flex justify-center gap-4">
                <a href="{{ route('contact') }}" class="rounded-full bg-coffee px-6 py-3 text-sm font-semibold text-cream shadow-md hover:bg-gold transition-colors duration-300">Contact Us</a>
                <a href="tel:+919876543210" class="rounded-full bg-white border border-amber-200 px-6 py-3 text-sm font-semibold text-coffee shadow-sm hover:bg-cream transition-colors duration-300">Call Now</a>
            </div>
        </div>
    </div>
</div>
@endsection
