<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-cream border border-coffee/20 rounded-xl font-bold text-xs md:text-sm text-coffee uppercase tracking-widest shadow-sm hover:bg-beige/30 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 disabled:opacity-25 transition-all duration-300 transform active:scale-95']) }}>
    {{ $slot }}
</button>

