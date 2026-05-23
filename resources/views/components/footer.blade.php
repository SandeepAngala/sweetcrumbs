<footer class="bg-gradient-to-b from-[#2C1810] to-[#120703] text-cream py-16 px-6 border-t border-coffee-800 font-body relative overflow-hidden">
    <!-- Ambient Gold Wave Decors -->
    <div class="absolute -right-32 -bottom-32 w-96 h-96 rounded-full bg-gold/5 blur-3xl"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10">
        
        <!-- About Column -->
        <div class="space-y-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-cookie-bite text-2xl text-gold"></i>
                <span class="font-display font-extrabold text-xl tracking-wider text-gold">SWEET CRUMBS</span>
            </a>
            <p class="text-sm text-cream/85 leading-relaxed font-normal">
                Crafting luxury artisanal breads, delicate viennoiseries, custom wedding tiers, and modern designer pastries daily with passion, heritage, and pure butter.
            </p>
            <div class="flex items-center gap-4 text-cream/70">
                <a href="#" class="hover:text-gold transition-colors duration-300"><i class="fa-brands fa-instagram text-xl"></i></a>
                <a href="#" class="hover:text-gold transition-colors duration-300"><i class="fa-brands fa-facebook text-xl"></i></a>
                <a href="#" class="hover:text-gold transition-colors duration-300"><i class="fa-brands fa-pinterest text-xl"></i></a>
                <a href="#" class="hover:text-gold transition-colors duration-300"><i class="fa-brands fa-youtube text-xl"></i></a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-6">
            <h4 class="font-display text-gold font-bold text-sm uppercase tracking-widest border-b border-coffee-800 pb-2">QUICK LINKS</h4>
            <ul class="space-y-3 text-sm text-cream/85 font-medium">
                <li><a href="{{ route('products.index') }}" class="hover:text-gold transition-colors duration-300 flex items-center gap-2"><i class="fa-solid fa-bread-slice text-gold w-5 text-center"></i> Bakery Menu</a></li>
                <li><a href="{{ route('custom-cake') }}" class="hover:text-gold transition-colors duration-300 flex items-center gap-2"><i class="fa-solid fa-cake-candles text-gold w-5 text-center"></i> Custom Cake Builder</a></li>
                <li><a href="{{ route('gallery') }}" class="hover:text-gold transition-colors duration-300 flex items-center gap-2"><i class="fa-solid fa-image text-gold w-5 text-center"></i> Photo Gallery</a></li>
                <li><a href="{{ route('testimonials') }}" class="hover:text-gold transition-colors duration-300 flex items-center gap-2"><i class="fa-solid fa-comments text-gold w-5 text-center"></i> Happy Reviews</a></li>
                <li><a href="{{ route('faq') }}" class="hover:text-gold transition-colors duration-300 flex items-center gap-2"><i class="fa-solid fa-circle-question text-gold w-5 text-center"></i> Help & FAQs</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="space-y-6">
            <h4 class="font-display text-gold font-bold text-sm uppercase tracking-widest border-b border-coffee-800 pb-2">CONTACT US</h4>
            <ul class="space-y-4 text-sm text-cream/85 font-normal">
                <li class="flex items-start gap-3">
                    <i class="fa-solid fa-location-dot text-base text-gold w-5 text-center mt-1"></i>
                    <span>102 Pastry Lane, Sweet Corner,<br>Colaba, Mumbai, MH - 400005</span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-phone text-base text-gold w-5 text-center"></i>
                    <span>+91 98765 43210</span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-envelope text-base text-gold w-5 text-center"></i>
                    <span>hello@sweetcrumbs.com</span>
                </li>
                <li class="flex items-center gap-3">
                    <i class="fa-solid fa-clock text-base text-gold w-5 text-center"></i>
                    <span>Daily: 7:00 AM - 10:00 PM</span>
                </li>
            </ul>
        </div>

        <!-- Newsletter subscription -->
        <div class="space-y-6" x-data="{ email: '', successMsg: '' }">
            <h4 class="font-display text-gold font-bold text-sm uppercase tracking-widest border-b border-coffee-800 pb-2">NEWSLETTER</h4>
            <p class="text-sm text-cream/85 leading-relaxed font-normal">
                Subscribe to get recipes, gourmet tips, and 10% off your first online order.
            </p>
            <form @submit.prevent="
                window.ajaxAction('{{ route('newsletter.subscribe') }}', { email: email }, (res) => {
                    if (res.success) {
                        successMsg = res.message;
                        email = '';
                    }
                });
            " class="flex flex-col gap-2">
                <div class="relative flex">
                    <input type="email" x-model="email" required placeholder="Your email address" class="w-full px-4 py-3 rounded-xl bg-coffee-950 border border-coffee-800 text-sm focus:outline-none focus:border-gold text-white placeholder-coffee-400">
                    <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 bg-gold text-coffee-950 font-bold rounded-lg text-xs hover:bg-gold/90 transition-colors">JOIN</button>
                </div>
                <template x-if="successMsg">
                    <div class="text-xs text-emerald-400 font-semibold" x-text="successMsg"></div>
                </template>
            </form>
        </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="max-w-7xl mx-auto mt-16 pt-8 border-t border-coffee-800/80 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-cream/70 font-normal">
        <div>&copy; 2026 Sweet Crumbs Bakery. All rights reserved. Made with <i class="fa-solid fa-heart text-rose-500 animate-pulse"></i> for gourmet lovers.</div>
        <div class="flex items-center gap-6">
            <a href="#" class="hover:text-gold transition-colors duration-300">Privacy Policy</a>
            <a href="#" class="hover:text-gold transition-colors duration-300">Terms of Service</a>
            <a href="#" class="hover:text-gold transition-colors duration-300">Sitemap</a>
        </div>
    </div>
</footer>

