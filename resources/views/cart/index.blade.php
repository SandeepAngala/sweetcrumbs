@extends('layouts.app')

@section('title', 'Your Gourmet Basket - Sweet Crumbs')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/20 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[['label' => 'Home', 'url' => route('home')], ['label' => 'Gourmet Basket', 'url' => '#']]" />
        </div>

        <x-section-heading 
            title="Your Gourmet Basket" 
            subtitle="Review your hand-selected delights before placing your fresh order"
            align="center"
        />

        <div class="mt-12 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-3">
            
            <!-- Left Side: Cart Items List -->
            <div class="lg:col-span-2 space-y-6">
                @if($cartItems->isEmpty())
                    <!-- Empty Cart State -->
                    <div class="text-center py-20 glass rounded-3xl">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-cream text-gold text-2xl mx-auto shadow-sm">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </div>
                        <h3 class="mt-6 text-2xl font-display font-bold text-coffee">Your basket is empty</h3>
                        <p class="mt-2 text-sm text-coffee-600 font-medium">You haven't added any sweet specialties to your basket yet.</p>
                        <div class="mt-8">
                            <a href="{{ route('products.index') }}" class="rounded-xl bg-coffee px-6 py-3.5 text-xs font-bold text-cream shadow-md hover:bg-gold transition-all duration-300">Browse Menu</a>
                        </div>
                    </div>
                @else
                    <!-- Cart Items -->
                    <div class="glass p-6 sm:p-8 rounded-3xl space-y-6">
                        @foreach($cartItems as $item)
                            <div class="flex flex-col sm:flex-row gap-6 border-b border-coffee-100/10 pb-6 last:border-b-0 last:pb-0" id="cart-item-{{ $item->product_id }}">
                                <!-- Thumbnail -->
                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-2xl border border-coffee-200/20 bg-cream/20">
                                    <img src="{{ $item->product->primary_image }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover" />
                                </div>

                                <!-- Details -->
                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h3 class="text-base md:text-lg font-display font-bold text-coffee hover:text-gold transition">
                                                <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                            </h3>
                                            <p class="mt-1 text-xs text-coffee-400 font-semibold">SKU: {{ $item->product->sku }}</p>
                                        </div>
                                        <div class="text-right">
                                            @if($item->product->discount_price)
                                                <span class="text-base md:text-lg font-bold text-gold font-display">₹{{ number_format($item->product->discount_price, 2) }}</span>
                                                <span class="block text-xs text-coffee-400 line-through">₹{{ number_format($item->product->price, 2) }}</span>
                                            @else
                                                <span class="text-base md:text-lg font-bold text-coffee font-display">₹{{ number_format($item->product->price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action footer -->
                                    <div class="mt-4 flex flex-wrap justify-between items-center gap-4">
                                        <!-- Quantity selection -->
                                        <div class="flex items-center rounded-xl bg-cream/70 ring-1 ring-inset ring-coffee-100/20 p-0.5">
                                            <button type="button" onclick="updateCartQty('{{ $item->product_id }}', -1)" class="h-8 w-8 text-coffee hover:text-gold transition font-bold"><i class="fa-solid fa-minus text-[10px]"></i></button>
                                            <span class="w-8 text-center font-extrabold text-coffee text-xs" id="qty-val-{{ $item->product_id }}">{{ $item->quantity }}</span>
                                            <button type="button" onclick="updateCartQty('{{ $item->product_id }}', 1)" class="h-8 w-8 text-coffee hover:text-gold transition font-bold"><i class="fa-solid fa-plus text-[10px]"></i></button>
                                        </div>

                                        <!-- Save & Delete actions -->
                                        <div class="flex items-center gap-4 text-xs font-bold text-coffee-500">
                                            <form action="{{ route('cart.save-for-later', $item->product_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="hover:text-gold transition flex items-center gap-1.5">
                                                    <i class="fa-regular fa-bookmark"></i> Save for Later
                                                </button>
                                            </form>
                                            
                                            <button onclick="removeCartItem('{{ $item->product_id }}')" class="hover:text-rose-600 text-rose-500 transition flex items-center gap-1.5">
                                                <i class="fa-regular fa-trash-can"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Side: Order Summary Panel -->
            <div class="space-y-6">
                <div class="glass p-6 sm:p-8 rounded-3xl space-y-6">
                    <h3 class="text-lg font-display font-bold text-coffee border-b border-coffee-100/10 pb-2">Basket Summary</h3>
                    
                    <div class="space-y-4 text-xs font-bold text-coffee-600">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="text-coffee font-extrabold" id="summary-subtotal">₹{{ number_format($totals['subtotal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>GST ({{ $bakery['tax_percent'] ?? 5 }}%):</span>
                            <span class="text-coffee font-extrabold" id="summary-tax">₹{{ number_format($totals['tax'], 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Fee:</span>
                            <span class="text-coffee font-extrabold" id="summary-delivery">
                                @if($totals['delivery_charge'] > 0)
                                    ₹{{ number_format($totals['delivery_charge'], 2) }}
                                @else
                                    <span class="text-emerald-600 uppercase font-extrabold">Free</span>
                                @endif
                            </span>
                        </div>
                        @if($totals['discount'] > 0)
                            <div class="flex justify-between text-emerald-600" id="summary-discount-row">
                                <span>Discount Coupon:</span>
                                <span class="font-extrabold">-₹{{ number_format($totals['discount'], 2) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Promo Code Form -->
                    <div class="border-t border-coffee-100/10 pt-6">
                        <form onsubmit="handleApplyCoupon(event)" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" id="coupon_code" placeholder="WELCOME10, FLAT100" required
                                   value="{{ session('coupon_code') }}"
                                   class="flex-1 rounded-xl border border-coffee-200 bg-cream/30 px-3 py-2 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                            <button type="submit" class="rounded-xl bg-coffee px-4 py-2 text-xs font-bold text-cream hover:bg-gold transition-colors duration-300">Apply</button>
                        </form>
                        <div id="coupon-msg" class="mt-2 text-[10px] hidden font-bold"></div>
                    </div>

                    <!-- Total Price & CTA -->
                    <div class="border-t border-coffee-100/10 pt-6 flex justify-between items-baseline">
                        <span class="text-sm font-bold text-coffee">Estimated Total:</span>
                        <div class="text-right">
                            <span class="text-2xl font-extrabold text-gold font-display" id="summary-total">₹{{ number_format($totals['total'], 2) }}</span>
                            <p class="text-[9px] text-coffee-400 font-semibold mt-1">Includes all taxes and packaging levies.</p>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full text-center rounded-2xl bg-coffee px-6 py-4 text-sm font-bold text-cream shadow-md hover:bg-gold hover:text-white transition duration-300 {{ $cartItems->isEmpty() ? 'pointer-events-none opacity-55' : '' }}">
                        Proceed to Checkout &nbsp;<i class="fa-solid fa-credit-card text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Saved For Later Section -->
        @if($savedItems->isNotEmpty())
            <div class="mt-20">
                <h3 class="text-xl font-display font-bold tracking-tight text-coffee border-b border-coffee-100/20 pb-4 mb-8 flex items-center gap-2">
                    <i class="fa-regular fa-bookmark text-gold"></i> Saved for Later ({{ $savedItems->count() }})
                </h3>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($savedItems as $save)
                        <div class="group relative overflow-hidden rounded-3xl glass p-4 flex flex-col justify-between">
                            <div>
                                <!-- Image -->
                                <div class="overflow-hidden rounded-2xl aspect-square bg-cream/10 relative">
                                    <img src="{{ $save->product->primary_image }}" alt="{{ $save->product->name }}" class="w-full h-full object-cover" />
                                </div>
                                <h4 class="text-sm font-display font-bold text-coffee mt-3 leading-snug group-hover:text-gold transition">
                                    <a href="{{ route('products.show', $save->product->slug) }}">{{ $save->product->name }}</a>
                                </h4>
                                <p class="text-xs text-gold font-bold font-display mt-2">₹{{ number_format($save->product->discount_price ?: $save->product->price, 2) }}</p>
                            </div>

                            <div class="mt-4 flex gap-2 border-t border-coffee-100/10 pt-3">
                                <form action="{{ route('cart.move-to-cart', $save->product_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full rounded-xl bg-coffee py-2 text-[10px] font-bold text-cream hover:bg-gold transition-colors duration-300">
                                        Move to Basket
                                    </button>
                                </form>
                                <button onclick="removeCartItem('{{ $save->product_id }}')" class="rounded-xl border border-rose-100 bg-rose-50 px-3 py-2 text-[10px] font-bold text-rose-600 hover:bg-rose-100 transition-colors duration-300">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function updateCartQty(productId, amount) {
        const qtySpan = document.getElementById('qty-val-' + productId);
        let qty = parseInt(qtySpan.textContent) + amount;
        if (qty < 1) return;

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                qtySpan.textContent = data.item_qty;
                updateSummary(data.totals);
                showToast(data.message, 'success');
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(err => showToast('Failed to update quantity.', 'error'));
    }

    function removeCartItem(productId) {
        fetch("{{ route('cart.remove') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showToast(data.message, 'success');
                // Reload page to refresh DOM structure smoothly
                window.location.reload();
            }
        })
        .catch(err => showToast('Failed to remove item.', 'error'));
    }

    function handleApplyCoupon(event) {
        event.preventDefault();
        const codeInput = document.getElementById('coupon_code');
        const code = codeInput.value;
        const msgDiv = document.getElementById('coupon-msg');

        fetch("{{ route('cart.coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {
            msgDiv.classList.remove('hidden', 'text-rose-600', 'text-emerald-600');
            if(data.success) {
                msgDiv.classList.add('text-emerald-600');
                msgDiv.textContent = data.message;
                updateSummary(data.totals);
                showToast('Coupon applied successfully!', 'success');
                // Smooth reload to show discounted column
                setTimeout(() => window.location.reload(), 1000);
            } else {
                msgDiv.classList.add('text-rose-600');
                msgDiv.textContent = data.message;
                showToast(data.message, 'error');
            }
        })
        .catch(err => showToast('Failed to apply coupon.', 'error'));
    }

    function updateSummary(totals) {
        document.getElementById('summary-subtotal').textContent = '₹' + totals.subtotal.toFixed(2);
        document.getElementById('summary-tax').textContent = '₹' + totals.tax.toFixed(2);
        
        const deliverySpan = document.getElementById('summary-delivery');
        if(totals.delivery_charge > 0) {
            deliverySpan.textContent = '₹' + totals.delivery_charge.toFixed(2);
        } else {
            deliverySpan.innerHTML = '<span class="text-emerald-600 uppercase">Free</span>';
        }
        
        document.getElementById('summary-total').textContent = '₹' + totals.total.toFixed(2);
    }
</script>
@endsection
