<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-coffee border border-transparent rounded-xl font-bold text-xs md:text-sm text-cream uppercase tracking-widest hover:bg-gold hover:text-white focus:bg-gold active:bg-coffee-700 focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 transition-all duration-300 transform active:scale-95 shadow-md']) }}>
    {{ $slot }}
</button>

