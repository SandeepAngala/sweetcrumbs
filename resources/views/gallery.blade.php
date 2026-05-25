@extends('layouts.app')

@section('title', 'MANA OORU MANA TEA Gallery - Gourmet Pastry Art')

@section('content')
<div class="relative bg-cream py-16 sm:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/40 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mb-8">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Visual Gallery', 'url' => '#']]" />
        </div>

        <x-section-heading title="A Feast for the Eyes" subtitle="Explore our visual archives of handcrafted pastries and celebration cakes" align="center" />

        <div class="mt-12 flex flex-wrap justify-center gap-3">
            <button type="button" onclick="filterGallery('all')" class="gallery-filter-btn active rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-200 bg-coffee text-cream transition-all">All</button>
            @foreach($categories as $cat)
            <button type="button" onclick="filterGallery('{{ $cat }}')" class="gallery-filter-btn rounded-full px-5 py-2 text-xs font-semibold shadow-sm border border-amber-100 bg-white text-coffee hover:bg-cream transition-all capitalize">{{ str_replace('_', ' ', $cat) }}</button>
            @endforeach
        </div>

        <div class="mt-16 columns-1 gap-6 sm:columns-2 lg:columns-3 space-y-6">
            @forelse($items as $item)
            @php
                $imgUrl = str_starts_with($item->image, 'http') ? $item->image : asset('storage/'.$item->image);
            @endphp
            <div class="gallery-item break-inside-avoid relative overflow-hidden rounded-3xl shadow-md group cursor-pointer hover:shadow-xl transition-all"
                 data-category="{{ $item->category }}"
                 onclick="openLightbox('{{ $imgUrl }}', @json($item->title), @json($item->description))">
                <img src="{{ $imgUrl }}" alt="{{ $item->title }}" class="w-full h-auto object-cover rounded-3xl transition duration-500 group-hover:scale-105" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-coffee/85 via-coffee/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-6">
                    <span class="text-xs text-gold font-bold uppercase tracking-wider capitalize">{{ $item->category }}</span>
                    <h4 class="text-lg font-bold text-cream font-playfair mt-1">{{ $item->title }}</h4>
                </div>
            </div>
            @empty
            <p class="col-span-full text-center text-coffee-500 py-12">Gallery items will appear here once added in the admin panel.</p>
            @endforelse
        </div>

        <div id="galleryLightbox" class="fixed inset-0 z-50 hidden bg-coffee/95 backdrop-blur-md flex items-center justify-center p-4" onclick="closeLightbox()">
            <button type="button" class="absolute top-6 right-6 text-cream text-3xl hover:text-gold" onclick="closeLightbox(event)"><i class="fa-solid fa-xmark"></i></button>
            <div class="max-w-4xl w-full flex flex-col lg:flex-row bg-cream rounded-3xl overflow-hidden shadow-2xl relative" onclick="event.stopPropagation()">
                <img id="lightboxImage" src="" alt="" class="w-full lg:w-1/2 object-cover max-h-[70vh]" />
                <div class="p-8 lg:w-1/2 flex flex-col justify-center">
                    <h3 id="lightboxTitle" class="text-2xl font-bold text-coffee font-playfair"></h3>
                    <p id="lightboxDesc" class="mt-4 text-sm text-gray-600 leading-relaxed"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterGallery(cat) {
    document.querySelectorAll('.gallery-filter-btn').forEach(b => b.classList.remove('active', 'bg-coffee', 'text-cream'));
    event.target.classList.add('active', 'bg-coffee', 'text-cream');
    document.querySelectorAll('.gallery-item').forEach(el => {
        el.style.display = (cat === 'all' || el.dataset.category === cat) ? '' : 'none';
    });
}
function openLightbox(src, title, desc) {
    document.getElementById('lightboxImage').src = src;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDesc').textContent = desc || '';
    document.getElementById('galleryLightbox').classList.remove('hidden');
}
function closeLightbox(e) { if (e) e.stopPropagation(); document.getElementById('galleryLightbox').classList.add('hidden'); }
</script>
@endpush
