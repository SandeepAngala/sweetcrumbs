@extends('layouts.dashboard')

@section('title', 'Order ' . $order->order_number)

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Top Bar Navigation & Print -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <a href="{{ route('dashboard.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-bakery-gold-600 dark:text-bakery-gold-400 hover:underline mb-2">
                <i class="fa-solid fa-arrow-left-long"></i> Back to My Orders
            </a>
            <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Order Details</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Invoice: <span class="font-mono font-semibold">{{ $order->order_number }}</span> • Placed: {{ $order->created_at->format('M j, Y, g:i A') }}</p>
        </div>
        <button onclick="window.print()" class="px-5 py-3 border border-coffee-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-700 shadow-sm flex items-center justify-center gap-2 transition-colors">
            <i class="fa-solid fa-print"></i> Print Invoice
        </button>
    </div>

    <!-- Interactive Elegant Order Tracker Stepper -->
    @if($order->status !== 'cancelled')
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-8 shadow-warm">
            <h2 class="font-display text-lg font-bold text-coffee-900 dark:text-white mb-6">Delivery Tracking</h2>
            
            @php
                $steps = [
                    ['label' => 'Placed', 'status' => 'pending', 'icon' => 'fa-solid fa-file-invoice-dollar'],
                    ['label' => 'Confirmed', 'status' => 'confirmed', 'icon' => 'fa-solid fa-clipboard-check'],
                    ['label' => 'In Kitchen', 'status' => 'processing', 'icon' => 'fa-solid fa-fire-burner'],
                    ['label' => 'On The Way', 'status' => 'shipped', 'icon' => 'fa-solid fa-truck-ramp-box'],
                    ['label' => 'Delivered', 'status' => 'delivered', 'icon' => 'fa-solid fa-house-chimney-user']
                ];
                
                $statuses = array_column($steps, 'status');
                $currentIdx = array_search($order->status, $statuses);
            @endphp

            <div class="relative flex flex-col md:flex-row justify-between items-center gap-8 md:gap-4 mt-4">
                <!-- Progress Line Connector (Desktop) -->
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-coffee-100 dark:bg-gray-700 -z-10 hidden md:block">
                    <div class="h-full bg-bakery-gold-500 transition-all duration-700" style="width: {{ $currentIdx * 25 }}%"></div>
                </div>

                @foreach($steps as $idx => $step)
                    <div class="flex md:flex-col items-center gap-4 md:gap-3 text-center z-10 w-full md:w-auto">
                        <!-- Step Bubble -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500 {{ $idx <= $currentIdx ? 'bg-bakery-gold-500 border-bakery-gold-500 text-coffee-950 shadow-md scale-110' : 'bg-white dark:bg-gray-800 border-coffee-200 dark:border-gray-600 text-coffee-300' }}">
                            <i class="{{ $step['icon'] }} text-base"></i>
                        </div>
                        
                        <!-- Step Text Labels -->
                        <div class="text-left md:text-center min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider {{ $idx <= $currentIdx ? 'text-coffee-950 dark:text-bakery-gold-400' : 'text-coffee-400 dark:text-gray-500' }}">{{ $step['label'] }}</p>
                            @if($idx === $currentIdx)
                                <span class="inline-block mt-0.5 text-xxs px-2 py-0.5 bg-bakery-gold-100 dark:bg-bakery-gold-950/40 text-bakery-gold-700 dark:text-bakery-gold-300 font-extrabold rounded-full uppercase tracking-wider">Active</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Cancelled State Alert Banner -->
        <div class="bg-rose-50 dark:bg-rose-950/20 rounded-3xl border border-rose-100 dark:border-rose-900/50 p-6 flex items-center gap-4 text-rose-800 dark:text-rose-400">
            <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
            <div>
                <h3 class="font-bold text-lg">Order Cancelled</h3>
                <p class="text-xs text-rose-600 dark:text-rose-500 mt-0.5">This order was cancelled. If you believe this is an error, please contact MANA OORU MANA TEA Customer Boutique support.</p>
            </div>
        </div>
    @endif

    <!-- Main Content Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Order Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-6 shadow-warm">
                <h2 class="font-display text-xl font-bold text-coffee-950 dark:text-white mb-6 border-b border-coffee-50 dark:border-gray-700 pb-3">Items Summary</h2>
                
                <div class="divide-y divide-coffee-50 dark:divide-gray-700">
                    @foreach($order->items as $item)
                        @php
                            $images = is_string($item->product->images) ? json_decode($item->product->images, true) : $item->product->images;
                            $primaryImage = $images[0] ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=600';
                        @endphp
                        <div class="py-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $primaryImage }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-2xl shadow-sm border border-coffee-100 dark:border-gray-700">
                                <div>
                                    <h3 class="font-bold text-coffee-900 dark:text-white hover:text-bakery-gold-600 transition-colors">
                                        <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-coffee-500 dark:text-gray-400">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-coffee-900 dark:text-white">₹{{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Total Billing Summaries -->
                <div class="border-t border-coffee-100 dark:border-gray-700 mt-6 pt-6 space-y-3">
                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>

                    @if($order->discount > 0)
                        <div class="flex justify-between text-green-600 dark:text-green-400 text-sm">
                            <span>Discount Coupon</span>
                            <span>-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>GST (5%)</span>
                        <span>₹{{ number_format($order->tax, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>Delivery Fee</span>
                        <span>
                            @if($order->delivery_charge == 0)
                                <span class="text-green-600 dark:text-green-400 font-bold uppercase text-xs">FREE</span>
                            @else
                                ₹{{ number_format($order->delivery_charge, 2) }}
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between text-lg font-bold text-coffee-950 dark:text-white pt-4 border-t border-coffee-50 dark:border-gray-700">
                        <span>Grand Total</span>
                        <span class="text-bakery-gold-600 dark:text-bakery-gold-400">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Shipping & Billing Details -->
        <div class="space-y-6">
            
            <!-- Delivery Info -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-6 shadow-warm">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 border-b border-coffee-50 dark:border-gray-700 pb-2">Delivery Details</h2>
                
                <div class="space-y-4 text-sm text-coffee-700 dark:text-gray-300">
                    <div>
                        <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-1">Time Slot Selected</span>
                        <p class="font-bold text-coffee-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($order->delivery_date)->format('l, F j, Y') }}
                        </p>
                        <p class="text-xs text-coffee-500 mt-0.5">Estimated: {{ $order->delivery_time_slot }}</p>
                    </div>

                    <div>
                        <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-1">Shipping Address</span>
                        @if($order->address)
                            <div class="font-semibold text-coffee-900 dark:text-white">{{ $order->address->label }}</div>
                            <p class="text-xs text-coffee-600 dark:text-gray-400 mt-1">
                                {{ $order->address->address_line_1 }}<br>
                                @if($order->address->address_line_2)
                                    {{ $order->address->address_line_2 }}<br>
                                @endif
                                {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->zip_code }}
                            </p>
                        @else
                            <p class="text-xs text-coffee-400 italic">No direct address linked.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-6 shadow-warm">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 border-b border-coffee-50 dark:border-gray-700 pb-2">Payment Info</h2>

                <div class="space-y-4 text-sm text-coffee-700 dark:text-gray-300">
                    <div>
                        <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-1">Payment Method</span>
                        <div class="font-bold text-coffee-900 dark:text-white flex items-center gap-1.5 uppercase text-xs">
                            @if($order->payment_method === 'cod')
                                <span class="px-2.5 py-0.5 bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 rounded-full border border-amber-200 dark:border-amber-800">Cash On Delivery</span>
                            @elseif($order->payment_method === 'stripe')
                                <span class="px-2.5 py-0.5 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 rounded-full border border-indigo-200 dark:border-indigo-800">Stripe Secure</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 rounded-full border border-blue-200 dark:border-blue-800">Razorpay</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-1">Payment Status</span>
                        <div>
                            @if($order->payment_status === 'paid')
                                <span class="payment-status-badge inline-flex items-center gap-1 px-2.5 py-0.5 bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full border border-green-200 dark:border-green-800">
                                    PAID
                                </span>
                            @else
                                <span class="payment-status-badge inline-flex items-center gap-1 px-2.5 py-0.5 bg-yellow-50 dark:bg-yellow-950/30 text-yellow-600 dark:text-yellow-400 text-xs font-bold rounded-full border border-yellow-200 dark:border-yellow-800">
                                    PENDING
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($order->payment_method === 'razorpay' && $order->payment_status !== 'paid')
                        <div id="razorpay-payment-container" class="mt-6 p-4 rounded-2xl bg-sky-50/50 dark:bg-sky-950/10 border border-sky-100 dark:border-sky-900/40 text-center transition-all duration-300">
                            <div class="mb-2 text-xl">🧁</div>
                            <h4 class="font-display font-bold text-coffee-950 dark:text-white text-xs mb-1">Pending Payment</h4>
                            <p class="text-[10px] text-coffee-500 dark:text-gray-400 mb-3 max-w-xs mx-auto">Click below to pay via secure Razorpay checkout.</p>
                            <button id="rzp-pay-btn" class="w-full py-2.5 bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-md transition-all duration-300 active:scale-98 text-xs inline-flex items-center justify-center gap-2">
                                <i class="fa-solid fa-credit-card"></i> Pay Now (₹{{ number_format($order->total, 2) }})
                            </button>
                        </div>
                    @endif

                    @if($order->payments && $order->payments->isNotEmpty())
                        <div>
                            <span class="text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 block mb-1">Transactions</span>
                            @foreach($order->payments as $payment)
                                <div class="p-2.5 bg-coffee-50 dark:bg-gray-900 rounded-xl border border-coffee-100 dark:border-gray-800 text-xxs font-mono space-y-0.5">
                                    <div>ID: <span class="font-bold">{{ $payment->transaction_id ?? 'N/A' }}</span></div>
                                    <div>Amount: ₹{{ number_format($payment->amount, 2) }}</div>
                                    <div>Status: <span class="uppercase font-bold">{{ $payment->status }}</span></div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

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
                            b.className = 'payment-status-badge inline-flex items-center gap-1 px-2.5 py-0.5 bg-green-50 dark:bg-green-950/30 text-green-600 dark:text-green-400 text-xs font-bold rounded-full border border-green-200 dark:border-green-800';
                            b.innerHTML = 'PAID';
                        });

                    } catch (verifyErr) {
                        payBtn.disabled = false;
                        payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Now (₹{{ number_format($order->total, 2) }})';
                        if (typeof window.showToast === 'function') {
                            window.showToast(verifyErr.message, 'error');
                        }
                    }
                },
                modal: {
                    ondismiss: function () {
                        payBtn.disabled = false;
                        payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Now (₹{{ number_format($order->total, 2) }})';
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
                payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Now (₹{{ number_format($order->total, 2) }})';
            });

            rzp.open();

        } catch (err) {
            payBtn.disabled = false;
            payBtn.innerHTML = '<i class="fa-solid fa-credit-card"></i> Pay Now (₹{{ number_format($order->total, 2) }})';
            if (typeof window.showToast === 'function') {
                window.showToast(err.message, 'error');
            }
        }
    });
});
</script>
@endpush

