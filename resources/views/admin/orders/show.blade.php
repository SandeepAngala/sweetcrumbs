@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.orders.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Manage Order</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Invoice: <span class="font-mono font-bold">{{ $order->order_number }}</span> • Placed: {{ $order->created_at->format('M j, Y, g:i A') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Order Summary & Customer Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Items summary card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
                <h2 class="font-display text-xl font-bold text-coffee-950 dark:text-white mb-6 border-b border-coffee-50 dark:border-gray-800 pb-3">Purchased Items</h2>
                
                <div class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @foreach($order->items as $item)
                        @php
                            $images = is_string($item->product->images) ? json_decode($item->product->images, true) : $item->product->images;
                            $primaryImage = $images[0] ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=600';
                        @endphp
                        <div class="py-4 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $primaryImage }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-2xl border border-coffee-100 dark:border-gray-700">
                                <div>
                                    <h3 class="font-bold text-coffee-900 dark:text-white">{{ $item->product->name }}</h3>
                                    <p class="text-xs text-coffee-500 dark:text-gray-400">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-coffee-900 dark:text-white">₹{{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Total Billing Summaries -->
                <div class="border-t border-coffee-100 dark:border-gray-800 mt-6 pt-6 space-y-3">
                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>

                    @if($order->discount > 0)
                        <div class="flex justify-between text-green-600 dark:text-green-400 text-sm">
                            <span>Discount Applied</span>
                            <span>-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>GST (5%)</span>
                        <span>₹{{ number_format($order->tax, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-coffee-600 dark:text-gray-400 text-sm">
                        <span>Delivery Fee</span>
                        <span>₹{{ number_format($order->delivery_charge, 2) }}</span>
                    </div>

                    <div class="flex justify-between text-lg font-bold text-coffee-950 dark:text-white pt-4 border-t border-coffee-50 dark:border-gray-800">
                        <span>Grand Total</span>
                        <span class="text-bakery-gold-600 dark:text-bakery-gold-400">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer brief and address -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- User Profile info -->
                <div>
                    <h3 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 border-b border-coffee-50 dark:border-gray-800 pb-2">Customer Profile</h3>
                    <div class="space-y-2 text-sm">
                        <p class="font-bold text-coffee-900 dark:text-white">{{ $order->user->name ?? 'Guest User' }}</p>
                        <p class="text-coffee-600 dark:text-gray-400">Email: <span class="font-semibold">{{ $order->user->email ?? 'N/A' }}</span></p>
                        <p class="text-coffee-600 dark:text-gray-400">Phone: <span class="font-semibold">{{ $order->user->phone ?? 'N/A' }}</span></p>
                    </div>
                </div>

                <!-- Shipping location -->
                <div>
                    <h3 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 border-b border-coffee-50 dark:border-gray-800 pb-2">Delivery Location</h3>
                    @if($order->address)
                        <div class="text-sm">
                            <span class="px-2 py-0.5 rounded bg-coffee-100 dark:bg-gray-800 text-coffee-700 dark:text-coffee-300 font-bold text-xxs mb-2 inline-block uppercase">{{ $order->address->label }}</span>
                            <p class="text-coffee-900 dark:text-white font-medium">{{ $order->address->address_line_1 }}</p>
                            @if($order->address->address_line_2)
                                <p class="text-coffee-600 dark:text-gray-400">{{ $order->address->address_line_2 }}</p>
                            @endif
                            <p class="text-coffee-600 dark:text-gray-400 text-xs">{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->zip_code }}</p>
                        </div>
                    @else
                        <p class="text-xs text-coffee-400 italic">No direct shipping address attached.</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Control Center (Update Status) -->
        <div class="space-y-6">
            
            <!-- Update Form Card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-bakery-gold-300 p-6 shadow-sm">
                <h2 class="font-display text-lg font-bold text-coffee-950 dark:text-white mb-4 pb-2 border-b border-coffee-50 dark:border-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-gear text-bakery-gold-500"></i> Order Control Center
                </h2>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Order status selection -->
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Order Status</label>
                        <select name="status" id="status" required class="w-full px-3 py-2.5 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white text-xs font-bold focus:ring-2 focus:ring-bakery-gold-400">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending (Received)</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed (Accpeted)</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>In Kitchen (Baking)</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment status selection -->
                    <div>
                        <label for="payment_status" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Payment Status</label>
                        <select name="payment_status" id="payment_status" required class="w-full px-3 py-2.5 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white text-xs font-bold focus:ring-2 focus:ring-bakery-gold-400">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('payment_status')
                            <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                        Save Order Changes
                    </button>
                </form>
            </div>

            <!-- Delivery Time Slot info -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
                <h3 class="font-display text-sm font-bold text-coffee-400 uppercase tracking-widest mb-3">Delivery Slot</h3>
                <p class="font-bold text-coffee-900 dark:text-white text-lg">
                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('l, F j, Y') }}
                </p>
                <p class="text-xs text-coffee-600 dark:text-gray-400 mt-1">Time Slot: <span class="font-semibold">{{ $order->delivery_time_slot }}</span></p>
                
                @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-coffee-50 dark:border-gray-800">
                        <span class="block text-xxs uppercase tracking-wider font-bold text-coffee-400 dark:text-gray-500 mb-1">Customer Note</span>
                        <p class="text-xs italic text-coffee-600 dark:text-gray-400 bg-coffee-50/50 dark:bg-gray-950 p-3 rounded-xl">"{{ $order->notes }}"</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
