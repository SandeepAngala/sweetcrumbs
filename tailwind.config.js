import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                cream: {
                    50: '#FFFAF5',
                    100: '#FFF7ED',
                    200: '#FFF1E0',
                    DEFAULT: '#FFF8F0',
                },
                beige: {
                    DEFAULT: '#F5E6D3',
                    dark: '#EAD7BF',
                },
                coffee: {
                    DEFAULT: '#2C1810',
                    50: '#FAF5F0',
                    100: '#F5E6D3',
                    200: '#E8D0B3',
                    300: '#D4A574',
                    400: '#C08552',
                    500: '#6F4E37',
                    600: '#5C3D2E',
                    700: '#3E2723',
                    800: '#2C1810',
                    900: '#1A0F0A',
                    950: '#120703',
                },
                'bakery-pink': {
                    50: '#FFF0F3',
                    100: '#FFE0E6',
                    200: '#FFB6C1',
                    300: '#FF8FA3',
                    400: '#FF6B85',
                },
                'bakery-gold': {
                    50: '#FFF9F0',
                    100: '#FFF0D4',
                    200: '#FFE0A8',
                    300: '#D4A574',
                    400: '#C08552',
                    500: '#A67B5B',
                },
                gold: {
                    DEFAULT: '#bf9143',
                    50: '#FFF9F0',
                    100: '#FFF0D4',
                    200: '#FFE0A8',
                    300: '#D4A574',
                    400: '#C08552',
                    500: '#A67B5B',
                },
            },
            fontFamily: {
                display: ['Playfair Display', ...defaultTheme.fontFamily.serif],
                body: ['Poppins', ...defaultTheme.fontFamily.sans],
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
                'shimmer': 'shimmer 1.5s infinite',
                'ripple': 'ripple 0.6s linear',
                'heart-beat': 'heartBeat 0.6s ease-in-out',
                'cart-bounce': 'cartBounce 0.5s ease-out',
                'glow-pulse': 'glowPulse 3s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                ripple: {
                    '0%': { transform: 'scale(0)', opacity: '0.5' },
                    '100%': { transform: 'scale(4)', opacity: '0' },
                },
                heartBeat: {
                    '0%': { transform: 'scale(1)' },
                    '15%': { transform: 'scale(1.3)' },
                    '30%': { transform: 'scale(1)' },
                    '45%': { transform: 'scale(1.15)' },
                    '60%, 100%': { transform: 'scale(1)' },
                },
                cartBounce: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '40%': { transform: 'translateY(-8px)' },
                    '60%': { transform: 'translateY(-4px)' },
                },
                glowPulse: {
                    '0%, 100%': { boxShadow: '0 0 5px rgba(191, 145, 67, 0.3)' },
                    '50%': { boxShadow: '0 0 20px rgba(191, 145, 67, 0.6)' },
                },
            },
            boxShadow: {
                'warm': '0 4px 14px 0 rgba(111, 78, 55, 0.12)',
                'warm-lg': '0 10px 25px -3px rgba(111, 78, 55, 0.18)',
                'glow': '0 0 20px rgba(212, 165, 116, 0.25)',
                'luxury': '0 8px 32px -4px rgba(44, 24, 16, 0.12), 0 4px 8px -2px rgba(44, 24, 16, 0.04)',
                'luxury-lg': '0 20px 60px -12px rgba(44, 24, 16, 0.2), 0 8px 16px -4px rgba(44, 24, 16, 0.06)',
                'luxury-hover': '0 24px 48px -12px rgba(44, 24, 16, 0.25), 0 12px 24px -8px rgba(44, 24, 16, 0.1)',
                'inner-glow': 'inset 0 1px 0 0 rgba(255, 255, 255, 0.1)',
            },
        },
    },
    plugins: [forms],
};
