@props(['title', 'subtitle' => ''])

<div class="text-center max-w-2xl mx-auto mb-16 space-y-3" data-aos="fade-up">
    @if($subtitle)
        <span class="text-xs font-bold text-bakery-gold-500 uppercase tracking-widest block">{{ $subtitle }}</span>
    @endif
    <h2 class="font-display font-bold text-3xl md:text-4xl text-coffee-900 dark:text-white relative inline-block pb-4">
        {{ $title }}
        <!-- Decorative Gold Underline -->
        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-16 h-0.5 bg-bakery-gold-300 rounded-full"></span>
        <span class="absolute bottom-[-4px] left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-bakery-gold-400 border-2 border-white dark:border-gray-900 shadow"></span>
    </h2>
</div>
