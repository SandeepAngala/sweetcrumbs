@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="py-12 bg-cream dark:bg-gray-900 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Animated Success Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-warm p-8 text-center border border-coffee-100 dark:border-gray-700 mb-8" data-aos="zoom-in">
            <div class="w-24 h-24 bg-green-50 dark:bg-green-950/30 rounded-full flex items-center justify-center mx-auto mb-6 border border-green-200 dark:border-green-800">
                <i class="fa-solid fa-wand-magic-sparkles text-5xl text-green-500 animate-bounce"></i>
            </div>
            
            <h1 class="font-display text-4xl font-extrabold text-coffee-900 dark:text-white mb-2">Order Confirmed!</h1>
            <p class="text-coffee-600 dark:text-gray-300 max-w-md mx-auto mb-6">
                Thank you for your order, <span class="font-semibold">{{ auth()->user()->name }}</span>! We've begun preparing your fresh artisanal treats.
            </p>

            <div class="inline-flex items-center gap-2 bg-coffee-50 dark:bg-gray-700/50 px-6 py-3 rounded-full border border-coffee-100 dark:border-gray-600 mb-4">
                <span class="text-coffee-500 dark:text-coffee-300 font-medium">Order Number:</span>
                <span class="font-mono font-bold text-bakery-gold-600 dark:text-bakery-gold-300">{{ $order->order_number }}</span>
            </div>

            <div class="text-sm text-coffee-500 dark:text-gray-400">
                A confirmation email has been sent to <span class="font-semibold">{{ auth()->user()->email }}</span>
            </div>
        </div>

        <!-- Order & Delivery Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Delivery Info -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-warm p-8 border border-coffee-100 dark:border-gray-700" data-aos="fade-right">
                <h2 class="font-display text-2xl font-bold text-coffee-950 dark:text-white mb-6 border-b border-coffee-50 dark:border-gray-700 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-truck text-bakery-gold-500"></i> Delivery Details
                </h2>
                
                <div class="space-y-4 text-coffee-700 dark:text-gray-300">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Estimated Delivery</div>
                        <div class="font-bold text-lg text-coffee-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('l, F j, Y') }}
                        </div>
                        <div class="text-sm text-coffee-500 dark:text-gray-400">
                            Time Slot: <span class="font-semibold">{{ $order->delivery_time_slot }}</span>
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Delivery Address</div>
                        @if($order->address)
                            <div class="font-medium text-coffee-900 dark:text-white">{{ $order->address->label }}</div>
                            <div class="text-sm text-coffee-600 dark:text-gray-400">
                                {{ $order->address->address_line_1 }}<br>
                                @if($order->address->address_line_2)
                                    {{ $order->address->address_line_2 }}<br>
                                @endif
                                {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->zip_code }}
                            </div>
                        @else
                            <div class="text-sm text-coffee-500 dark:text-gray-400 italic">No specific address linked.</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-warm p-8 border border-coffee-100 dark:border-gray-700" data-aos="fade-left">
                <h2 class="font-display text-2xl font-bold text-coffee-950 dark:text-white mb-6 border-b border-coffee-50 dark:border-gray-700 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-bakery-gold-500"></i> Payment Information
                </h2>

                <div class="space-y-4 text-coffee-700 dark:text-gray-300">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Payment Method</div>
                        <div class="font-bold text-coffee-900 dark:text-white flex items-center gap-2">
                            @if($order->payment_method === 'cod')
                                <span class="px-3 py-1 bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 text-xs font-bold rounded-full border border-amber-200 dark:border-amber-800 uppercase">Cash On Delivery</span>
                            @elseif($order->payment_method === 'stripe')
                                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-full border border-indigo-200 dark:border-indigo-800 uppercase">Stripe Secure</span>
                            @else
                                <span class="px-3 py-1 bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full border border-blue-200 dark:border-blue-800 uppercase">Razorpay</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Payment Status</div>
                        <div>
                            @if($order->payment_status === 'paid')
                                <span class="payment-status-badge inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full border border-green-200 dark:border-green-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></span> PAID
                                </span>
                            @else
                                <span class="payment-status-badge inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 dark:bg-yellow-950/30 text-yellow-600 dark:text-yellow-400 text-xs font-bold rounded-full border border-yellow-200 dark:border-yellow-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> PENDING PAYMENT
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($order->payment_method === 'razorpay' && $order->payment_status !== 'paid')
                        <div id="razorpay-payment-container" class="mt-6 p-5 rounded-2xl bg-sky-50/50 dark:bg-sky-950/10 border border-sky-100 dark:border-sky-900/40 text-center transition-all duration-300">
                            <div class="mb-3 text-2xl">🧁</div>
                            <h4 class="font-display font-bold text-coffee-950 dark:text-white text-sm mb-1">Complete Payment</h4>
                            <p class="text-xxs text-coffee-500 dark:text-gray-400 mb-4 max-w-xs mx-auto">Please authorize your order payment via secure Razorpay checkout.</p>
                            <button id="rzp-pay-btn" class="w-full py-3 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-md transition-all duration-300 active:scale-98 text-xs inline-flex items-center justify-center gap-2">
                                <i class="fa-solid fa-credit-card"></i> Pay Securely Now (₹{{ number_format($order->total, 2) }})
                            </button>
                        </div>
                    @endif

                    @if($order->notes)
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Special Instructions</div>
                            <p class="text-sm italic text-coffee-600 dark:text-gray-400">"{{ $order->notes }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary Card -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-warm p-8 border border-coffee-100 dark:border-gray-700 mb-8" data-aos="fade-up">
            <h2 class="font-display text-2xl font-bold text-coffee-950 dark:text-white mb-6 border-b border-coffee-50 dark:border-gray-700 pb-3">Order Items</h2>
            
            <div class="divide-y divide-coffee-50 dark:divide-gray-700">
                @foreach($order->items as $item)
                    <div class="py-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @php
                                $images = is_string($item->product->images) ? json_decode($item->product->images, true) : $item->product->images;
                                $primaryImage = $images[0] ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=600';
                            @endphp
                            <img src="{{ $primaryImage }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-2xl shadow-sm border border-coffee-100 dark:border-gray-700">
                            <div>
                                <h3 class="font-bold text-coffee-900 dark:text-white">{{ $item->product->name }}</h3>
                                <p class="text-sm text-coffee-500 dark:text-gray-400">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                        <span class="font-bold text-coffee-900 dark:text-white">₹{{ number_format($item->total, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Total Breakdowns -->
            <div class="border-t border-coffee-100 dark:border-gray-700 mt-6 pt-6 space-y-3">
                <div class="flex justify-between text-coffee-600 dark:text-gray-400">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                @if($order->discount > 0)
                    <div class="flex justify-between text-green-600 dark:text-green-400">
                        <span>Discount Applied</span>
                        <span>-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif

                <div class="flex justify-between text-coffee-600 dark:text-gray-400">
                    <span>GST (5%)</span>
                    <span>₹{{ number_format($order->tax, 2) }}</span>
                </div>

                <div class="flex justify-between text-coffee-600 dark:text-gray-400">
                    <span>Delivery Charge</span>
                    <span>
                        @if($order->delivery_charge == 0)
                            <span class="text-green-600 dark:text-green-400 font-bold uppercase text-xs">FREE</span>
                        @else
                            ₹{{ number_format($order->delivery_charge, 2) }}
                        @endif
                    </span>
                </div>

                <div class="flex justify-between text-lg font-bold text-coffee-950 dark:text-white pt-3 border-t border-coffee-50 dark:border-gray-700">
                    <span>Grand Total</span>
                    <span class="text-bakery-gold-600 dark:text-bakery-gold-400">₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Call to Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('dashboard.orders') }}" class="px-8 py-4 rounded-full bg-coffee-800 text-white hover:bg-coffee-900 transition-all font-semibold shadow-warm text-center flex items-center justify-center gap-2 hover:-translate-y-0.5">
                <i class="fa-solid fa-list-check"></i> Track Your Order
            </a>
            <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-full bg-bakery-gold-500 text-coffee-950 hover:bg-bakery-gold-600 transition-all font-semibold shadow-warm text-center flex items-center justify-center gap-2 hover:-translate-y-0.5">
                <i class="fa-solid fa-cookie"></i> Continue Shopping
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const payBtn = document.getElementById('rzp-pay-btn');
    if (!payBtn) return;

    payBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        
        // Prevent double clicking
        payBtn.disabled = true;
        payBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin"></i> Initializing Payment...';

        try {
            // 1. Create order on the backend
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch('{{ route("checkout.razorpay.create") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order_number: '{{ $order->order_number }}'
                })
            });

            if (!response.ok) {
                const errData = await response.json().catch(() => ({}));
                throw new Error(errData.message || 'Failed to create payment order. Please try again.');
            }

            const data = await response.json();
            
            // 2. Configure Razorpay options
            const options = {
                key: data.key_id,
                amount: data.amount,
                currency: data.currency,
                name: data.bakery.name,
                description: 'Order Payment #' + '{{ $order->order_number }}',
                order_id: data.order_id,
                theme: {
                    color: '#b45309' // Matches the premium amber/coffee gold theme of the boutique!
                },
                prefill: {
                    name: data.customer.name,
                    email: data.customer.email,
                    contact: data.customer.phone
                },
                handler: async function (response) {
                    // Show processing state
                    payBtn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin"></i> Verifying Payment...';
                    
                    try {
                        // 3. Verify on the backend
                        const verifyRes = await fetch('{{ route("checkout.razorpay.verify") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                order_number: '{{ $order->order_number }}',
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        });

                        if (!verifyRes.ok) {
                            const errData = await verifyRes.json().catch(() => ({}));
                            throw new Error(errData.message || 'Signature verification failed.');
                        }

                        const verifyData = await verifyRes.json();
                        
                        if (typeof window.showToast === 'function') {
                            window.showToast('🧁 Payment successful! Thank you for ordering.', 'success');
                        }

                        // Seamlessly update page UI state without page reload!
                        const container = document.getElementById('razorpay-payment-container');
                        if (container) {
                            container.innerHTML = `
                                <div class="text-emerald-500 font-bold text-xs flex items-center justify-center gap-1.5 mt-2">
                                    <i class="fa-solid fa-circle-check"></i> PAYMENT COMPLETED
                                </div>
                            `;
                        }

                        // Update standard paid badges in view
                        const badges = document.querySelectorAll('.payment-status-badge');
                        badges.forEach(b => {
                            b.className = 'payment-status-badge inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full border border-green-200 dark:border-green-800';
                            b.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping"></span> PAID';
                        });

                    } catch (verifyErr) {
                        payBtn.disabled = false;
                        payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Securely Now (₹{{ number_format($order->total, 2) }})';
                        if (typeof window.showToast === 'function') {
                            window.showToast(verifyErr.message, 'error');
                        }
                    }
                },
                modal: {
                    ondismiss: function () {
                        payBtn.disabled = false;
                        payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Securely Now (₹{{ number_format($order->total, 2) }})';
                        if (typeof window.showToast === 'function') {
                            window.showToast('Payment window was closed by the user.', 'warning');
                        }
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (resp) {
                if (typeof window.showToast === 'function') {
                    window.showToast('Payment Failed: ' + resp.error.description, 'error');
                }
                payBtn.disabled = false;
                payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Securely Now (₹{{ number_format($order->total, 2) }})';
            });

            rzp.open();

        } catch (err) {
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Securely Now (₹{{ number_format($order->total, 2) }})';
            if (typeof window.showToast === 'function') {
                window.showToast(err.message, 'error');
            }
        }
    });
});
</script>
@endpush

