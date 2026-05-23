@extends('layouts.app')

@section('title', 'Our Story - Sweet Crumbs Bakery')

@section('content')
<div class="relative overflow-hidden bg-cream py-16 sm:py-24">
    <!-- Background elements -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>
    <div class="absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-amber-50/50 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 h-[600px] w-[600px] rounded-full bg-amber-100/30 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'About Us', 'url' => '#']]" />
        </div>

        <!-- Section Heading -->
        <x-section-heading 
            title="Our Sweet Journey" 
            subtitle="The Story of Passion, Flour, and Edible Artistry"
            align="center"
        />

        <!-- Narrative Section -->
        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-center">
            <div class="relative group">
                <div class="absolute -inset-4 rounded-3xl bg-gradient-to-tr from-gold/20 to-coffee/10 opacity-30 blur-lg transition duration-500 group-hover:opacity-50"></div>
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=800&auto=format&fit=crop" 
                     alt="Chef Sandeep baking" 
                     class="relative w-full aspect-[4/3] rounded-3xl object-cover shadow-2xl transition duration-500 group-hover:scale-[1.01]" />
            </div>
            
            <div class="flex flex-col justify-center">
                <p class="text-lg font-semibold leading-8 text-gold font-playfair">Est. 2018</p>
                <h3 class="mt-2 text-3xl font-bold tracking-tight text-coffee font-playfair sm:text-4xl">Where Every Crumb Tells a Story</h3>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Founded by Chef Sandeep in 2018, Sweet Crumbs Bakery began as a tiny kitchen table experiment fueled by a big dream and a single bag of organic French flour. Our goal has always been simple: to elevate daily moments with extraordinary, hand-rolled confections that look like fine art and taste like heaven.
                </p>
                <p class="mt-6 text-base leading-7 text-gray-600">
                    We believe in slow baking—the quiet rhythm of natural fermentation, the precise lamination of cold butter, and the warm aroma of caramelized crusts wafting through the early morning air. Every ingredient we choose is ethically sourced, from local grass-fed butter to organic, single-origin dark chocolate.
                </p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('products.index') }}" class="rounded-full bg-coffee px-6 py-3 text-sm font-semibold text-cream shadow-md hover:bg-gold transition-colors duration-300">Explore Our Menu</a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold leading-6 text-coffee hover:text-gold transition-colors duration-300">Contact Chef <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading 
                title="Our Core Philosophy" 
                subtitle="The principles that guide our ovens and pastry bags every single day"
                align="center"
            />
            
            <dl class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <!-- Value 1 -->
                <div class="flex flex-col items-center text-center p-8 bg-white/70 backdrop-blur-md border border-amber-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <dt class="flex flex-col items-center gap-y-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gold/10 text-gold text-2xl">
                            <i class="fa-solid fa-wheat-awn"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-coffee font-playfair">Uncompromising Ingredients</span>
                    </dt>
                    <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                        <p class="flex-auto">We source only the finest raw ingredients—organic flours, real AOP French butter, fresh farm-direct fruits, and raw honeycomb. No preservatives, ever.</p>
                    </dd>
                </div>

                <!-- Value 2 -->
                <div class="flex flex-col items-center text-center p-8 bg-white/70 backdrop-blur-md border border-amber-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <dt class="flex flex-col items-center gap-y-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gold/10 text-gold text-2xl">
                            <i class="fa-solid fa-palette"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-coffee font-playfair">Edible Artistry</span>
                    </dt>
                    <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                        <p class="flex-auto">Every pastry is detailed by hand. From complex chocolate mirror glazes to delicate sugar flowers and gold leaves, our desserts are designed to stun.</p>
                    </dd>
                </div>

                <!-- Value 3 -->
                <div class="flex flex-col items-center text-center p-8 bg-white/70 backdrop-blur-md border border-amber-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <dt class="flex flex-col items-center gap-y-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gold/10 text-gold text-2xl">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-coffee font-playfair">Warm Hospitality</span>
                    </dt>
                    <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                        <p class="flex-auto">Baking is an act of sharing love. Whether you purchase a single warm butter croissant or a grand wedding cake, we serve you with joy and gratitude.</p>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Team Section -->
        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading 
                title="Meet the Culinary Artisans" 
                subtitle="The creative hands and passionate hearts behind our gorgeous creations"
                align="center"
            />

            <ul role="list" class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <!-- Chef 1 -->
                <li class="group">
                    <div class="relative overflow-hidden rounded-3xl aspect-[3/4] shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=400&auto=format&fit=crop" alt="Chef Sandeep">
                        <div class="absolute inset-0 bg-gradient-to-t from-coffee/90 via-coffee/40 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-xl font-bold tracking-tight text-cream font-playfair">Chef Sandeep</h3>
                            <p class="text-sm text-gold">Founder & Executive Pastry Chef</p>
                            <p class="mt-3 text-sm text-cream/80">Trained in Paris under world-renowned master bakers. Loves playing with complex textures and organic sugars.</p>
                        </div>
                    </div>
                </li>

                <!-- Chef 2 -->
                <li class="group">
                    <div class="relative overflow-hidden rounded-3xl aspect-[3/4] shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1581299894007-aaa50297cf16?q=80&w=400&auto=format&fit=crop" alt="Chef Sarah">
                        <div class="absolute inset-0 bg-gradient-to-t from-coffee/90 via-coffee/40 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-xl font-bold tracking-tight text-cream font-playfair">Sarah Jenkins</h3>
                            <p class="text-sm text-gold">Head Bread Artisan</p>
                            <p class="mt-3 text-sm text-cream/80">Our sourdough queen. Sarah nurtures a 65-year-old starter inherited from her grandmother with absolute devotion.</p>
                        </div>
                    </div>
                </li>

                <!-- Chef 3 -->
                <li class="group">
                    <div class="relative overflow-hidden rounded-3xl aspect-[3/4] shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        <img class="h-full w-full object-cover transition duration-500 group-hover:scale-105" src="https://images.unsplash.com/photo-1607990283143-e81e7a2c93ab?q=80&w=400&auto=format&fit=crop" alt="Chef Marcus">
                        <div class="absolute inset-0 bg-gradient-to-t from-coffee/90 via-coffee/40 to-transparent flex flex-col justify-end p-6">
                            <h3 class="text-xl font-bold tracking-tight text-cream font-playfair">Marcus Vance</h3>
                            <p class="text-sm text-gold">Master Chocolatier</p>
                            <p class="mt-3 text-sm text-cream/80">Obsessed with cacao origins and silky mirror glazes. Ensures our dark chocolate truffles are pure perfection.</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Interactive Timeline Section -->
        <div class="mx-auto mt-32 max-w-7xl sm:mt-40">
            <x-section-heading 
                title="Our Timeline" 
                subtitle="The milestones of our sweet bakery adventure"
                align="center"
            />
            
            <div class="relative mx-auto mt-16 max-w-3xl">
                <!-- Vertical Line -->
                <div class="absolute left-1/2 h-full w-0.5 -translate-x-1/2 bg-gold/30"></div>
                
                <div class="space-y-12">
                    <!-- Timeline Item 1 -->
                    <div class="relative flex items-center justify-between group">
                        <div class="w-[45%] text-right pr-8">
                            <span class="text-lg font-bold text-gold">2018</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">The Humble Beginning</h4>
                            <p class="text-sm text-gray-600 mt-2">Chef Sandeep rents a tiny garage in Sweet Town, baking simple macarons and selling them at local farmers markets.</p>
                        </div>
                        <div class="absolute left-1/2 z-10 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full bg-gold text-cream border-4 border-cream shadow-md group-hover:scale-110 transition duration-300">
                            <i class="fa-solid fa-seedling text-xs"></i>
                        </div>
                        <div class="w-[45%]"></div>
                    </div>

                    <!-- Timeline Item 2 -->
                    <div class="relative flex items-center justify-between group">
                        <div class="w-[45%]"></div>
                        <div class="absolute left-1/2 z-10 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full bg-coffee text-cream border-4 border-cream shadow-md group-hover:scale-110 transition duration-300">
                            <i class="fa-solid fa-store text-xs"></i>
                        </div>
                        <div class="w-[45%] text-left pl-8">
                            <span class="text-lg font-bold text-gold">2020</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">First Boutique Café</h4>
                            <p class="text-sm text-gray-600 mt-2">We open our flagship bakery and café doors. Gourmet food lovers queue around the block for hot butter croissants.</p>
                        </div>
                    </div>

                    <!-- Timeline Item 3 -->
                    <div class="relative flex items-center justify-between group">
                        <div class="w-[45%] text-right pr-8">
                            <span class="text-lg font-bold text-gold">2023</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">Award Winning Pastries</h4>
                            <p class="text-sm text-gray-600 mt-2">Awarded "Best Artisanal Bakery in the State" for our outstanding French lamination and wild sourdough loaves.</p>
                        </div>
                        <div class="absolute left-1/2 z-10 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full bg-gold text-cream border-4 border-cream shadow-md group-hover:scale-110 transition duration-300">
                            <i class="fa-solid fa-trophy text-xs"></i>
                        </div>
                        <div class="w-[45%]"></div>
                    </div>

                    <!-- Timeline Item 4 -->
                    <div class="relative flex items-center justify-between group">
                        <div class="w-[45%]"></div>
                        <div class="absolute left-1/2 z-10 flex h-8 w-8 -translate-x-1/2 items-center justify-center rounded-full bg-coffee text-cream border-4 border-cream shadow-md group-hover:scale-110 transition duration-300">
                            <i class="fa-solid fa-laptop text-xs"></i>
                        </div>
                        <div class="w-[45%] text-left pl-8">
                            <span class="text-lg font-bold text-gold">2026</span>
                            <h4 class="text-xl font-bold text-coffee font-playfair mt-1">The Digital Bakery</h4>
                            <p class="text-sm text-gray-600 mt-2">Launching a fully premium digital ordering experience, complete with live tracking, custom cake builder, and loyalty perks.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
