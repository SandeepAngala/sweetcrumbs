@extends('layouts.app')

@section('title', 'Secure Checkout - MANA OORU MANA TEA Boutique')

@section('content')
<div class="relative bg-cream min-h-screen py-12 overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/20 via-cream to-cream"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('home')],
                ['label' => 'Basket', 'url' => route('cart.index')],
                ['label' => 'Checkout', 'url' => '#']
            ]" />
        </div>

        <x-section-heading 
            title="Secure Checkout" 
            subtitle="Complete your order by confirming address and selecting payment options"
            align="center"
        />

        <form action="{{ route('checkout.store') }}" method="POST" class="mt-12 grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-3">
            @csrf
            
            <!-- Left Panel: Delivery Details & Payments -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Step 1: Delivery Address -->
                <div class="glass p-6 sm:p-8 rounded-3xl">
                    <h3 class="text-lg font-display font-bold text-coffee border-b border-coffee-100/10 pb-3 mb-6 flex items-center gap-2.5">
                        <span class="h-7 w-7 rounded-full bg-gold/10 text-gold border border-gold/20 flex items-center justify-center text-xs font-bold">1</span>
                        Delivery Address
                    </h3>

                    @if($addresses->isEmpty())
                        <!-- New Address Form direct inline -->
                        <div class="space-y-4">
                            <p class="text-xs text-coffee-500 font-semibold mb-4">You do not have any saved addresses. Please enter a delivery address below:</p>
                            <input type="hidden" name="new_address[label]" value="Home" />
                            <input type="hidden" name="new_address[country]" value="India" />
                            <input type="hidden" name="new_address[state]" value="Delhi" />
                            
                            <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-coffee uppercase tracking-wider mb-1.5">Address Line 1</label>
                                    <input type="text" name="new_address[address_line_1]" required placeholder="Apartment / Suite, Building name, Street"
                                           class="mt-1 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-coffee uppercase tracking-wider mb-1.5">Address Line 2 (Optional)</label>
                                    <input type="text" name="new_address[address_line_2]" placeholder="Landmark or locality"
                                           class="mt-1 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-coffee uppercase tracking-wider mb-1.5">City</label>
                                    <input type="text" name="new_address[city]" required value="New Delhi"
                                           class="mt-1 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-coffee uppercase tracking-wider mb-1.5">Zip / Postal Code</label>
                                    <input type="text" name="new_address[zip_code]" required placeholder="e.g. 110001"
                                           class="mt-1 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Address picker -->
                        <div class="space-y-4">
                            <label class="block text-xs font-bold text-coffee uppercase tracking-wider mb-3">Select a saved address</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($addresses as $addr)
                                    <label class="relative flex p-4 rounded-2xl border border-coffee-100/10 bg-white/40 backdrop-blur-sm shadow-sm cursor-pointer hover:border-gold transition">
                                        <input type="radio" name="address_id" value="{{ $addr->id }}" {{ $addr->is_default ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 border-coffee-200 text-gold focus:ring-gold" />
                                        <div class="ml-3 text-xs font-semibold">
                                            <span class="block font-bold text-coffee capitalize text-sm">{{ $addr->label }}</span>
                                            <span class="block mt-1 text-coffee-600">{{ $addr->address_line_1 }}</span>
                                            <span class="block text-coffee-600">{{ $addr->city }}, {{ $addr->zip_code }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Step 2: Time Slots & Dates -->
                <div class="glass p-6 sm:p-8 rounded-3xl">
                    <h3 class="text-lg font-display font-bold text-coffee border-b border-coffee-100/10 pb-3 mb-6 flex items-center gap-2.5">
                        <span class="h-7 w-7 rounded-full bg-gold/10 text-gold border border-gold/20 flex items-center justify-center text-xs font-bold">2</span>
                        Delivery Schedule
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Date picker -->
                        <div>
                            <label for="delivery_date" class="block text-xs font-bold text-coffee uppercase tracking-wider">Select Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" required min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="mt-2 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold" />
                        </div>

                        <!-- Time slots -->
                        <div>
                            <label for="delivery_time_slot" class="block text-xs font-bold text-coffee uppercase tracking-wider">Preferable Time Slot</label>
                            <select name="delivery_time_slot" id="delivery_time_slot" required
                                    class="mt-2 block w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2.5 text-xs text-coffee font-bold focus:border-gold focus:ring-gold">
                                @foreach(($bakery['delivery_slots'] ?? []) as $slot)
                                <option value="{{ $slot }}">{{ $slot }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment Options -->
                <div class="glass p-6 sm:p-8 rounded-3xl">
                    <h3 class="text-lg font-display font-bold text-coffee border-b border-coffee-100/10 pb-3 mb-6 flex items-center gap-2.5">
                        <span class="h-7 w-7 rounded-full bg-gold/10 text-gold border border-gold/20 flex items-center justify-center text-xs font-bold">3</span>
                        Secure Payments
                    </h3>

                    <div class="space-y-4">
                        <!-- Cash on Delivery -->
                        <label class="relative flex p-4 rounded-2xl border border-coffee-100/10 bg-white/40 backdrop-blur-sm shadow-sm cursor-pointer hover:border-gold transition items-center justify-between">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" checked
                                       class="h-4 w-4 border-coffee-200 text-gold focus:ring-gold" />
                                <div class="ml-3 text-xs font-semibold">
                                    <span class="block font-bold text-coffee text-sm">Cash on Delivery</span>
                                    <span class="block text-coffee-500 mt-0.5">Pay with cash or card upon fresh delivery.</span>
                                </div>
                            </div>
                            <span class="text-lg text-coffee"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                        </label>

                        <label class="relative flex p-4 rounded-2xl border border-coffee-100/10 bg-white/40 backdrop-blur-sm shadow-sm cursor-pointer hover:border-gold transition items-center justify-between">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="upi"
                                       class="h-4 w-4 border-coffee-200 text-gold focus:ring-gold" />
                                <div class="ml-3 text-xs font-semibold">
                                    <span class="block font-bold text-coffee text-sm">UPI Payment</span>
                                    <span class="block text-coffee-500 mt-0.5">Pay via UPI at checkout (reference sent after order).</span>
                                </div>
                            </div>
                            <span class="text-lg text-emerald-600"><i class="fa-solid fa-mobile-screen"></i></span>
                        </label>

                        @if(!empty($paymentOnlineEnabled))
                        <label class="relative flex p-4 rounded-2xl border border-coffee-100/10 bg-white/40 backdrop-blur-sm shadow-sm cursor-pointer hover:border-gold transition items-center justify-between">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="stripe"
                                       class="h-4 w-4 border-coffee-200 text-gold focus:ring-gold" />
                                <div class="ml-3 text-xs font-semibold">
                                    <span class="block font-bold text-coffee text-sm">Stripe Secure Card</span>
                                    <span class="block text-coffee-500 mt-0.5">Card payments (configured gateway).</span>
                                </div>
                            </div>
                            <span class="text-lg text-indigo-600"><i class="fa-brands fa-cc-stripe"></i></span>
                        </label>

                        <label class="relative flex p-4 rounded-2xl border border-coffee-100/10 bg-white/40 backdrop-blur-sm shadow-sm cursor-pointer hover:border-gold transition items-center justify-between">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="razorpay"
                                       class="h-4 w-4 border-coffee-200 text-gold focus:ring-gold" />
                                <div class="ml-3 text-xs font-semibold">
                                    <span class="block font-bold text-coffee text-sm">Razorpay Gateway</span>
                                    <span class="block text-coffee-500 mt-0.5">UPI, NetBanking, and wallets.</span>
                                </div>
                            </div>
                            <span class="text-lg text-sky-600"><i class="fa-solid fa-credit-card"></i></span>
                        </label>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Panel: Basket Overview & Order CTA -->
            <div class="space-y-6 lg:col-span-1">
                <div class="glass p-6 sm:p-8 rounded-3xl space-y-6">
                    <h3 class="text-lg font-display font-bold text-coffee border-b border-coffee-100/10 pb-2">Order Summary</h3>

                    <!-- Mini Cart Items list -->
                    <div class="divide-y divide-coffee-100/10 max-h-56 overflow-y-auto pr-2">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                                <img src="{{ $item->product->primary_image }}" class="h-10 w-10 rounded-xl object-cover border border-coffee-100/10" />
                                <div class="flex-1 text-xs font-semibold">
                                    <span class="block font-bold text-coffee truncate">{{ $item->product->name }}</span>
                                    <span class="text-coffee-400">{{ $item->quantity }} x ₹{{ number_format($item->product->discount_price ?: $item->product->price, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Receipt calculations -->
                    <div class="border-t border-coffee-100/10 pt-6 space-y-4 text-xs font-bold text-coffee-600">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="text-coffee font-extrabold">₹{{ number_format($totals['subtotal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>GST (5%):</span>
                            <span class="text-coffee font-extrabold">₹{{ number_format($totals['tax'], 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Charge:</span>
                            <span class="text-coffee font-extrabold">
                                @if($totals['delivery_charge'] > 0)
                                    ₹{{ number_format($totals['delivery_charge'], 2) }}
                                @else
                                    <span class="text-emerald-600 uppercase font-extrabold">Free</span>
                                @endif
                            </span>
                        </div>
                        @if($totals['discount'] > 0)
                            <div class="flex justify-between text-emerald-600">
                                <span>Discount Coupon:</span>
                                <span class="font-extrabold">-₹{{ number_format($totals['discount'], 2) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Total Amount & Place Order -->
                    <div class="border-t border-coffee-100/10 pt-6 flex justify-between items-baseline mb-4">
                        <span class="text-sm font-bold text-coffee">Total Investment:</span>
                        <span class="text-2xl font-extrabold text-gold font-display">₹{{ number_format($totals['total'], 2) }}</span>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-xs font-bold text-coffee uppercase tracking-wider mb-2">Delivery instructions / notes</label>
                        <textarea name="notes" id="notes" rows="2" placeholder="e.g. Please leave at door, don't ring bell..."
                                  class="w-full rounded-xl border border-coffee-200 bg-cream/20 px-3 py-2 text-xs text-coffee font-bold focus:border-gold focus:ring-gold"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full text-center rounded-2xl bg-coffee px-6 py-4 text-sm font-bold text-cream shadow-md hover:bg-gold hover:text-white transition duration-300 transform active:scale-98">
                        Confirm & Place Order &nbsp;<i class="fa-solid fa-circle-check text-xs"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
