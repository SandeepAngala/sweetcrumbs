<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sweet Crumbs') }} - Authentication</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- CSS CDNs -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Inline Theme Script (Prevent Flash) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Custom Luxury Styles & Animations -->
        <style>
            @keyframes cinematicZoom {
                0% { transform: scale(1); }
                50% { transform: scale(1.08); }
                100% { transform: scale(1); }
            }
            .cinematic-bg {
                animation: cinematicZoom 24s ease-in-out infinite;
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            .dark .glassmorphism {
                background: rgba(18, 7, 3, 0.82);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            @keyframes softSteam {
                0% { transform: translateY(0) scale(1) rotate(0deg); opacity: 0; }
                50% { opacity: 0.35; }
                100% { transform: translateY(-120px) scale(1.6) rotate(15deg); opacity: 0; }
            }
            .steam-particle {
                animation: softSteam 7s ease-out infinite;
            }
            .input-group:focus-within label,
            .input-group input:not(:placeholder-shown) + label {
                transform: translateY(-24px) scale(0.85);
                color: #bf9143;
                font-weight: 700;
            }
            .social-btn {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .social-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(111, 78, 55, 0.15);
            }
        </style>
    </head>
    <body class="font-body text-coffee-800 dark:text-gray-200 antialiased min-h-screen h-full">
        <!-- Main split screen wrapper -->
        <div class="min-h-screen flex flex-col md:flex-row bg-[#FDFBF7] dark:bg-gray-950 transition-colors duration-500 relative overflow-hidden">
            
            <!-- Left Side: Cinematic Branding (hidden on mobile) -->
            <div class="hidden md:flex md:w-1/2 lg:w-7/12 relative overflow-hidden bg-coffee-950 flex-col justify-between p-12 text-white">
                
                <!-- Background Image Layer -->
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat cinematic-bg opacity-90 transition-all duration-1000" 
                     style="background-image: url('https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=1280');">
                </div>

                <!-- Ambient Vignette & Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-t from-coffee-950 via-coffee-950/60 to-coffee-900/35 z-10"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-coffee-950/25 to-coffee-950/75 z-10"></div>

                <!-- Custom Floating Steam Particles -->
                <div class="absolute inset-0 pointer-events-none overflow-hidden z-10">
                    <div class="steam-particle bg-white/10 w-4 h-4 rounded-full absolute bottom-12 left-1/4 filter blur-sm" style="animation-delay: 0s; animation-duration: 6s;"></div>
                    <div class="steam-particle bg-white/10 w-6 h-6 rounded-full absolute bottom-16 left-1/3 filter blur-md" style="animation-delay: 2s; animation-duration: 8s;"></div>
                    <div class="steam-particle bg-white/10 w-3 h-3 rounded-full absolute bottom-8 left-1/2 filter blur-sm" style="animation-delay: 4.5s; animation-duration: 7s;"></div>
                    <div class="steam-particle bg-white/10 w-5 h-5 rounded-full absolute bottom-14 left-2/3 filter blur-md" style="animation-delay: 1.5s; animation-duration: 9s;"></div>
                </div>

                <!-- Top Row: Minimalist Navigation -->
                <div class="z-20 flex justify-between items-center" data-aos="fade-down" data-aos-duration="1000">
                    <a href="/" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/10 text-xs font-bold transition-all hover:scale-105 active:scale-95 text-white shadow-sm">
                        <i class="fa-solid fa-arrow-left-long"></i> Back to Home
                    </a>
                </div>

                <!-- Center Content: Logo & Brand Tagline -->
                <div class="my-auto z-20 flex flex-col items-start max-w-lg" data-aos="fade-right" data-aos-duration="1200">
                    <!-- Brand Icon with golden floating animation -->
                    <div class="w-16 h-16 bg-bakery-gold-100/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-glow mb-6 animate-float">
                        <i class="fa-solid fa-cookie-bite text-3xl text-bakery-gold-300"></i>
                    </div>

                    <!-- Main Brand Header -->
                    <h1 class="font-display text-4xl lg:text-5xl font-black tracking-tight leading-none text-white">
                        Sweet Crumbs
                    </h1>
                    <span class="mt-2 text-xs font-bold uppercase tracking-[0.25em] text-bakery-gold-300">Café & Artisanal Bakery</span>
                    
                    <!-- Decorative glowing divider -->
                    <div class="w-16 h-0.5 bg-gradient-to-r from-bakery-gold-400 to-transparent my-6"></div>

                    <!-- Narrative quote -->
                    <p class="text-base text-coffee-100 font-medium leading-relaxed italic font-display">
                        "Freshly baked happiness, crafted with premium AOP butter, local ingredients, and artisanal love."
                    </p>
                </div>

                <!-- Bottom Row: Decorative info -->
                <div class="z-20 flex justify-between items-center text-xxs text-coffee-200 border-t border-white/10 pt-4" data-aos="fade-up" data-aos-duration="1000">
                    <span>Est. 2026 &bull; Sweet Crumbs Bakery</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle text-green-400 animate-pulse text-[6px]"></i> Oven Hot & Baking</span>
                </div>

            </div>

            <!-- Right Side: Authentication Form Card Wrapper -->
            <div class="w-full md:w-1/2 lg:w-5/12 flex flex-col justify-between items-center p-4 sm:p-12 relative min-h-screen z-20">
                
                <!-- Mobile Background (Blurred version of same photo) -->
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-[6px] md:hidden scale-105 opacity-95 transition-all duration-1000" 
                     style="background-image: url('https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=1280');">
                </div>
                <div class="absolute inset-0 bg-cream-50/90 dark:bg-gray-950/90 md:hidden transition-colors duration-500 z-0"></div>

                <!-- Top Row Form Controls: Home & Theme Toggle -->
                <div class="w-full flex justify-between items-center md:justify-end gap-3 z-30 mb-8 md:mb-0">
                    <a href="/" class="md:hidden flex items-center justify-center w-11 h-11 rounded-2xl bg-white dark:bg-gray-800 border border-coffee-100 dark:border-gray-700 text-coffee-600 dark:text-gray-300 shadow-sm active:scale-95 transition-all">
                        <i class="fa-solid fa-house"></i>
                    </a>
                    
                    <button id="dark-mode-toggle" class="flex items-center justify-center w-11 h-11 rounded-2xl bg-white dark:bg-gray-800 border border-coffee-100 dark:border-gray-700 text-coffee-600 dark:text-gray-300 shadow-sm hover:bg-coffee-50 dark:hover:bg-gray-750 active:scale-95 transition-all" title="Toggle theme">
                        <i class="fa-solid fa-circle-half-stroke"></i>
                    </button>
                </div>

                <!-- Interactive Glassmorphic Form Card -->
                <div class="w-full max-w-md glassmorphism border border-coffee-100/30 dark:border-gray-800/40 shadow-luxury rounded-[32px] p-6 sm:p-10 my-auto z-10 transition-all duration-300 hover:shadow-luxury-hover hover:border-bakery-gold-300/30 flex flex-col justify-center"
                     data-aos="zoom-in" data-aos-duration="900">
                    {{ $slot }}
                </div>

                <!-- Global Toast alert container -->
                <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-3 max-w-sm w-full"></div>

                <!-- Footer Trademark watermark -->
                <p class="mt-8 md:mt-0 text-center text-xxs text-coffee-400 dark:text-gray-500 z-10">
                    &copy; {{ date('Y') }} Sweet Crumbs Bakery. All rights reserved.
                </p>

            </div>

        </div>

        <!-- AOS Init -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 50
                });
            });
        </script>
    </body>
</html>
