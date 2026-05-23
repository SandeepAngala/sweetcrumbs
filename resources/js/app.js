import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const htmlElement = document.documentElement;
    const darkToggleBtn = document.getElementById('dark-mode-toggle');

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
                fetch(`/search?query=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                })
                    .then(response => response.json())
                    .then(data => {
                        searchSuggestions.innerHTML = '';
                        if (!data.length) {
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
                    .catch(() => searchSuggestions.classList.add('hidden'));
            }, 300);
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                searchSuggestions.classList.add('hidden');
            }
        });
    }
});

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
            <span class="text-lg">${type === 'success' ? '🧁' : type === 'error' ? '⚠️' : '🔔'}</span>
            <span class="text-sm font-semibold">${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-coffee-300 hover:text-coffee-600 dark:text-gray-400 dark:hover:text-white">&times;</button>
    `;

    container.appendChild(toast);
    setTimeout(() => toast.classList.remove('translate-y-4', 'opacity-0'), 10);
    setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};

window.updateNavbarCartCount = function(count) {
    document.querySelectorAll('.cart-count-badge').forEach(badge => {
        badge.innerText = count;
        if (count > 0) {
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    });
};

window.requireAuth = function(action = 'continue') {
    if (window.isAuthenticated) return true;
    window.showToast(`Please log in to ${action}.`, 'error');
    setTimeout(() => {
        window.location.href = window.loginUrl || '/login';
    }, 800);
    return false;
};

window.ajaxAction = function(url, data, successCallback) {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(data),
        credentials: 'same-origin',
    })
    .then(async response => {
        if (response.status === 401 || response.status === 419) {
            window.requireAuth('use this feature');
            throw new Error('Authentication required');
        }
        const payload = await response.json().catch(() => ({}));
        if (!response.ok) {
            throw new Error(payload.message || 'Something went wrong');
        }
        return payload;
    })
    .then(data => {
        if (successCallback) successCallback(data);
        return data;
    })
    .catch(err => {
        if (err.message !== 'Authentication required') {
            window.showToast(err.message, 'error');
        }
    });
};

window.addToCartAjax = function(productId, quantity = 1) {
    window.ajaxAction('/cart/add', { product_id: productId, quantity }, (res) => {
        if (res.success) {
            window.showToast(res.message, 'success');
            window.updateNavbarCartCount(res.cart_count);
        }
    });
};

window.toggleWishlistAjax = function(productId, btnElement = null) {
    if (!window.requireAuth('manage your wishlist')) return;

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

document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-premium');
    if (!btn) return;

    const ripple = document.createElement('span');
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - rect.left - size / 2}px;top:${e.clientY - rect.top - size / 2}px;position:absolute;border-radius:50%;background:rgba(255,255,255,0.35);transform:scale(0);animation:ripple 0.6s linear;pointer-events:none`;
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
});

document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('main > section, main > div > section').forEach(section => {
        section.classList.add('reveal-section');
        observer.observe(section);
    });
});

const _origAddToCart = window.addToCartAjax;
window.addToCartAjax = function(productId, quantity = 1) {
    const btn = document.activeElement?.closest('.btn-cart');
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
