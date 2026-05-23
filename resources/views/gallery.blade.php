@extends('layouts.app')

@section('title', 'Sweet Crumbs Gallery - Gourmet Pastry Art')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <!-- Decorative backgrounds -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Visual Gallery', 'url' => '#']]" />
        </div>

        <!-- Heading -->
        <x-section-heading 
            title="A Feast for the Eyes" 
            subtitle="Explore our visual archives of hand-rolled pastries, celebratory custom cakes, and daily café moments"
            align="center"
        />

        <!-- Category Filters -->
        <div class="mt-12 flex flex-wrap justify-center gap-3">
            <button onclick="filterGallery('all')" class="gallery-filter-btn active rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-200 bg-coffee text-cream transition-all duration-300">All Masterpieces</button>
            <button onclick="filterGallery('cakes')" class="gallery-filter-btn rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-100 bg-white text-coffee hover:bg-cream transition-all duration-300">Cakes</button>
            <button onclick="filterGallery('croissants')" class="gallery-filter-btn rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-100 bg-white text-coffee hover:bg-cream transition-all duration-300">French Pastries</button>
            <button onclick="filterGallery('breads')" class="gallery-filter-btn rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-100 bg-white text-coffee hover:bg-cream transition-all duration-300">Artisanal Breads</button>
            <button onclick="filterGallery('cookies')" class="gallery-filter-btn rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-100 bg-white text-coffee hover:bg-cream transition-all duration-300">Cookies & Macarons</button>
        </div>

        <!-- Masonry Grid -->
        <div class="mt-16 columns-1 gap-6 sm:columns-2 lg:columns-3 xl:columns-3 space-y-6">
            <!-- Item 1 (Cake) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="cakes" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1000&auto=format&fit=crop', 'Royal Velvet Celebration Cake', 'Four layers of velvety red sponge filled with raspberry coulis and decorated with gold flakes.')">
                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=600&auto=format&fit=crop" 
                     alt="Royal Velvet Celebration Cake" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">Signature Cakes</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">Royal Velvet Celebration</h4>
                </div>
            </div>

            <!-- Item 2 (Pastry) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="croissants" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=1000&auto=format&fit=crop', 'Classic Parisian Butter Croissant', 'Flaky, buttery, laminated pastry with a beautiful honeycomb crumb.')">
                <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=600&auto=format&fit=crop" 
                     alt="Classic Parisian Butter Croissant" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">French Pastries</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">Parisian Butter Croissant</h4>
                </div>
            </div>

            <!-- Item 3 (Breads) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="breads" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1549931319-a545dcf3bc73?q=80&w=1000&auto=format&fit=crop', 'Artisanal Wild Sourdough Crust', 'Blistered, golden, caramelized crust with wild natural fermentation.')">
                <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?q=80&w=600&auto=format&fit=crop" 
                     alt="Artisanal Wild Sourdough" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">Artisanal Breads</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">Wild Sourdough Boule</h4>
                </div>
            </div>

            <!-- Item 4 (Cookies) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="cookies" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1569864358642-9d1684040f43?q=80&w=1000&auto=format&fit=crop', 'Exquisite Parisian Macaron Selection', 'Delicate, sweet, ganache-filled almond macarons in vibrant natural flavors.')">
                <img src="https://images.unsplash.com/photo-1569864358642-9d1684040f43?q=80&w=600&auto=format&fit=crop" 
                     alt="Parisian Macaron Selection" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">Cookies & Macarons</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">French Macaron Box</h4>
                </div>
            </div>

            <!-- Item 5 (Cake) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="cakes" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1535141192574-5d4897c13636?q=80&w=1000&auto=format&fit=crop', 'Three-Tier Wedding Masterpiece', 'Custom luxury wedding cake loaded with fresh white roses and hand-piped frosting.')">
                <img src="https://images.unsplash.com/photo-1535141192574-5d4897c13636?q=80&w=600&auto=format&fit=crop" 
                     alt="Three-Tier Wedding Masterpiece" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">Signature Cakes</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">Royal White Floral Wedding</h4>
                </div>
            </div>

            <!-- Item 6 (Pastry) -->
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all duration-500" 
                 data-category="croissants" 
                 onclick="openLightbox('https://images.unsplash.com/photo-1519869325930-281384150729?q=80&w=1000&auto=format&fit=crop', 'Glazed Sweet Fruit Tart', 'Sweet crisp shell layered with diplomatic cream and glistening fresh berries.')">
                <img src="https://images.unsplash.com/photo-1519869325930-281384150729?q=80&w=600&auto=format&fit=crop" 
                     alt="Glazed Sweet Fruit Tart" 
                     class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider">French Pastries</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">Premium Berry Diplomat Tart</h4>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div id="galleryLightbox" class="fixed inset-0 z-50 hidden bg-coffee/95 backdrop-blur-md flex items-center justify-center p-4" onclick="closeLightbox()">
            <!-- Close button -->
            <button class="absolute top-6 right-6 text-cream text-3xl hover:text-gold transition-colors duration-300" onclick="closeLightbox(event)">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <div class="max-w-4xl w-full flex flex-col lg:flex-row bg-cream rounded-3xl overflow-hidden shadow-2xl relative" onclick="event.stopPropagation()">
                <div class="lg:w-2/3 h-[300px] lg:h-[500px]">
                    <img id="lightboxImg" src="" alt="" class="w-full h-full object-cover" />
                </div>
                <div class="lg:w-1/3 p-8 flex flex-col justify-between bg-cream">
                    <div>
                        <span id="lightboxCat" class="text-xs text-gold font-bold uppercase tracking-wider">Category</span>
                        <h3 id="lightboxTitle" class="text-2xl font-bold tracking-tight text-coffee font-playfair mt-2">Title</h3>
                        <p id="lightboxDesc" class="mt-4 text-sm text-gray-600 leading-relaxed">Description goes here.</p>
                    </div>
                    <div class="mt-8">
                        <button onclick="closeLightbox()" class="rounded-xl border border-coffee px-5 py-2.5 text-sm font-semibold text-coffee hover:bg-coffee hover:text-cream transition-colors duration-300 w-full">Back to Gallery</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterGallery(category) {
        // Toggle active button
        const buttons = document.querySelectorAll('.gallery-filter-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-coffee', 'text-cream', 'border-amber-200');
            btn.classList.add('bg-white', 'text-coffee', 'border-amber-100', 'hover:bg-cream');
        });
        
        event.currentTarget.classList.remove('bg-white', 'text-coffee', 'border-amber-100', 'hover:bg-cream');
        event.currentTarget.classList.add('bg-coffee', 'text-cream', 'border-amber-200');

        // Filter items
        const items = document.querySelectorAll('.gallery-item');
        items.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function openLightbox(imgUrl, title, desc) {
        document.getElementById('lightboxImg').src = imgUrl;
        document.getElementById('lightboxTitle').textContent = title;
        document.getElementById('lightboxDesc').textContent = desc;
        
        // Find category label
        const clickedItem = event.currentTarget;
        const categoryLabel = clickedItem.querySelector('span').textContent;
        document.getElementById('lightboxCat').textContent = categoryLabel;

        document.getElementById('galleryLightbox').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeLightbox(event) {
        if(event) event.stopPropagation();
        document.getElementById('galleryLightbox').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
