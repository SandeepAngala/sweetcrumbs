import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Custom Bakery Scripts
document.addEventListener('DOMContentLoaded', () => {
    // 1. Dark Mode Setup
    const htmlElement = document.documentElement;
    const darkToggleBtn = document.getElementById('dark-mode-toggle');

    // Load initial dark mode state
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark');
    } else {
        htmlElement.classList.remove('dark');
    }

    if (darkToggleBtn) {
        darkToggleBtn.addEventListener('click', () => {
            if (htmlElement.classList.contains('dark')) {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // 2. Sticky Navbar Scroll Effect
    const navbar = document.getElementById('main-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }

    // 3. Back to Top Button
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.classList.remove('hidden');
                backToTopBtn.classList.add('flex');
            } else {
                backToTopBtn.classList.add('hidden');
                backToTopBtn.classList.remove('flex');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 4. Live Search with Debounce
    const searchInput = document.getElementById('global-search-input');
    const searchSuggestions = document.getElementById('search-suggestions');
    let debounceTimer;

    if (searchInput && searchSuggestions) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const query = e.target.value.trim();

            if (query.length < 2) {
                searchSuggestions.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchSuggestions.innerHTML = '';
                        if (data.length === 0) {
                            searchSuggestions.innerHTML = '<div class="p-4 text-center text-sm text-coffee-400">No products found...</div>';
                        } else {
                            data.forEach(item => {
                                const div = document.createElement('a');
                                div.href = item.url;
                                div.className = 'flex items-center gap-3 p-3 hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors border-b border-coffee-100/5 last:border-b-0';
                                div.innerHTML = `
                                    <img src="${item.image}" alt="${item.name}" class="w-10 h-10 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <div class="text-sm font-semibold text-coffee-900 dark:text-white">${item.name}</div>
                                        <div class="text-xs text-coffee-500 font-medium">₹${item.price}</div>
                                    </div>
                                `;
                                searchSuggestions.appendChild(div);
                            });
                        }
                        searchSuggestions.classList.remove('hidden');
                    })
                    .catch(() => {
                        searchSuggestions.classList.add('hidden');
                    });
            }, 300);
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.add('hidden');
            }
        });
    }
});

// Toast notification helper
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast-alert flex items-center justify-between gap-4 p-4 rounded-xl shadow-warm-lg transition-all duration-300 transform translate-y-4 opacity-0 max-w-sm w-full font-body ${
        type === 'success' 
            ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-800 dark:text-emerald-300 border-l-4 border-emerald-500' 
            : type === 'error'
            ? 'bg-rose-50 dark:bg-rose-950/30 text-rose-800 dark:text-rose-300 border-l-4 border-rose-500'
            : 'bg-amber-50 dark:bg-amber-950/30 text-amber-800 dark:text-amber-300 border-l-4 border-amber-500'
    }`;

    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="text-lg">${
                type === 'success' ? '🧁' : type === 'error' ? '⚠️' : '🔔'
            }</span>
            <span class="text-sm font-semibold">${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-coffee-300 hover:text-coffee-600 dark:text-gray-400 dark:hover:text-white">&times;</button>
    `;

    container.appendChild(toast);

    // Trigger animation
    setTimeout(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
    }, 10);

    // Auto dismiss
    setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 4000);
};

// AJAX Cart & Wishlist helper actions
window.ajaxAction = function(url, data, successCallback) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw new Error(err.message || 'Something went wrong'); });
        }
        return response.json();
    })
    .then(data => {
        if (successCallback) successCallback(data);
        return data;
    })
    .catch(err => {
        window.showToast(err.message, 'error');
    });
};

// Global Cart Trigger Action
window.addToCartAjax = function(productId, quantity = 1) {
    window.ajaxAction('/cart/add', { product_id: productId, quantity: quantity }, (res) => {
        if (res.success) {
            window.showToast(res.message, 'success');
            // Update cart badges
            const badges = document.querySelectorAll('.cart-count-badge');
            badges.forEach(badge => {
                badge.innerText = res.cart_count;
                badge.classList.remove('hidden');
            });
        }
    });
};

// Global Wishlist Trigger Action
window.toggleWishlistAjax = function(productId, btnElement = null) {
    window.ajaxAction('/wishlist/toggle', { product_id: productId }, (res) => {
        if (res.success) {
            window.showToast(res.message, 'success');
            if (btnElement) {
                const icon = btnElement.querySelector('i');
                if (res.status === 'added') {
                    icon.classList.remove('fa-regular', 'text-coffee-400');
                    icon.classList.add('fa-solid', 'text-rose-500');
                } else {
                    icon.classList.remove('fa-solid', 'text-rose-500');
                    icon.classList.add('fa-regular', 'text-coffee-400');
                }
            }
        }
    });
};

// ============================================
// PREMIUM MICRO-INTERACTIONS
// ============================================

// Ripple effect on premium buttons
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-premium');
    if (!btn) return;

    const ripple = document.createElement('span');
    ripple.classList.add('ripple');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = `${size}px`;
    ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
    ripple.style.top = `${e.clientY - rect.top - size / 2}px`;
    ripple.style.position = 'absolute';
    ripple.style.borderRadius = '50%';
    ripple.style.background = 'rgba(255, 255, 255, 0.35)';
    ripple.style.transform = 'scale(0)';
    ripple.style.animation = 'ripple 0.6s linear';
    ripple.style.pointerEvents = 'none';
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
});

// Smooth section reveal on scroll (IntersectionObserver)
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    // Only observe main content sections, not nested ones
    document.querySelectorAll('main > section, main > div > section').forEach(section => {
        section.classList.add('reveal-section');
        observer.observe(section);
    });
});

// Enhanced addToCartAjax with animation
const _origAddToCart = window.addToCartAjax;
window.addToCartAjax = function(productId, quantity = 1) {
    // Find the closest button from the event
    const btn = document.activeElement?.closest('.btn-cart') || document.querySelector(`button[onclick*="addToCartAjax(${productId})"]`);
    if (btn) {
        btn.classList.add('cart-added');
        const icon = btn.querySelector('i');
        const label = btn.querySelector('span');
        if (icon) {
            icon.classList.remove('fa-cart-shopping');
            icon.classList.add('fa-check');
        }
        if (label) label.textContent = 'ADDED!';
        setTimeout(() => {
            if (icon) {
                icon.classList.remove('fa-check');
                icon.classList.add('fa-cart-shopping');
            }
            if (label) label.textContent = 'ADD';
            btn.classList.remove('cart-added');
        }, 1500);
    }
    _origAddToCart(productId, quantity);
};

// Enhanced toggleWishlistAjax with heart animation
const _origToggleWishlist = window.toggleWishlistAjax;
window.toggleWishlistAjax = function(productId, btnElement = null) {
    if (btnElement) {
        const icon = btnElement.querySelector('i');
        if (icon) {
            icon.classList.add('heart-pop');
            setTimeout(() => icon.classList.remove('heart-pop'), 600);
        }
    }
    _origToggleWishlist(productId, btnElement);
};
