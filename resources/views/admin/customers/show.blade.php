@extends('layouts.admin')

@section('content')
<div class="space-y-8 animate-fade-in">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.customers.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Customer Dossier</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Detailed history, orders, addresses, and reviews for this registered patron</p>
        </div>
    </div>

    <!-- Customer Brief Profile Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Customer Profile Info Card -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm flex flex-col items-center text-center relative overflow-hidden">
                <!-- Decorative background radial gradient -->
                <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full bg-gradient-to-br from-bakery-gold-200/20 to-coffee-100/10 blur-2xl"></div>

                <!-- Avatar -->
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-coffee-700 to-coffee-950 text-white font-bold border-4 border-white dark:border-gray-800 text-3xl shadow-luxury flex items-center justify-center uppercase mb-4 shrink-0 z-10">
                    @if($customer->avatar)
                        <img src="{{ $customer->avatar }}" alt="{{ $customer->name }}" class="w-full h-full object-cover rounded-full">
                    @else
                        {{ substr($customer->name, 0, 2) }}
                    @endif
                </div>

                <!-- Basic details -->
                <h2 class="font-display text-xl font-bold text-coffee-900 dark:text-white z-10">{{ $customer->name }}</h2>
                <span class="text-xxs font-mono text-coffee-400 dark:text-gray-500 mb-4 z-10">Patron ID: #{{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</span>

                <!-- Loyalty Point Banner -->
                @php
                    $points = $customer->loyalty_points ?? 0;
                    if ($points >= 600) {
                        $tier = 'Pastry Master';
                        $tierClass = 'bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900';
                        $tierIcon = 'fa-solid fa-crown';
                        $progress = min(100, ($points / 1000) * 100);
                        $nextTier = 'Supreme Gourmand (1000 pts)';
                    } elseif ($points >= 300) {
                        $tier = 'Butter Elite';
                        $tierClass = 'bg-coffee-100 dark:bg-coffee-950/30 text-coffee-800 dark:text-coffee-300 border border-coffee-200 dark:border-coffee-900';
                        $tierIcon = 'fa-solid fa-medal';
                        $progress = (($points - 300) / 300) * 100;
                        $nextTier = 'Pastry Master (600 pts)';
                    } elseif ($points >= 100) {
                        $tier = 'Honey Enthusiast';
                        $tierClass = 'bg-orange-50 dark:bg-orange-950/20 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900';
                        $tierIcon = 'fa-solid fa-star';
                        $progress = (($points - 100) / 200) * 100;
                        $nextTier = 'Butter Elite (300 pts)';
                    } else {
                        $tier = 'Sugar Apprentice';
                        $tierClass = 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
                        $tierIcon = 'fa-solid fa-cookie';
                        $progress = ($points / 100) * 100;
                        $nextTier = 'Honey Enthusiast (100 pts)';
                    }
                @endphp
                <div class="w-full bg-coffee-50 dark:bg-gray-955 p-4 rounded-2xl border border-coffee-100/50 dark:border-gray-800 mb-6 text-left">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xxs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-widest">Loyalty Tier</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider flex items-center gap-1 {{ $tierClass }}">
                            <i class="{{ $tierIcon }}"></i> {{ $tier }}
                        </span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <span class="text-lg font-black text-coffee-900 dark:text-white">{{ $points }}</span>
                        <span class="text-xxs text-coffee-400 dark:text-gray-500">Points Balance</span>
                    </div>
                    
                    <!-- Progress Bar to next tier -->
                    <div class="w-full bg-coffee-100 dark:bg-gray-800 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-bakery-gold-500 h-1.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <span class="text-[10px] text-coffee-400 dark:text-gray-500 block mt-1.5 font-semibold">Next level: {{ $nextTier }}</span>
                </div>

                <!-- Personal Info Details -->
                <div class="w-full text-left space-y-4 text-xs border-t border-coffee-50 dark:border-gray-800 pt-6">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-coffee-400 dark:text-gray-500 tracking-wider mb-1">Email Address</span>
                        <span class="font-semibold text-coffee-900 dark:text-white">{{ $customer->email }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-coffee-400 dark:text-gray-500 tracking-wider mb-1">Phone Number</span>
                        @if($customer->phone)
                            <span class="font-semibold text-coffee-900 dark:text-white">{{ $customer->phone }}</span>
                        @else
                            <span class="italic text-coffee-400">No phone attached</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-coffee-400 dark:text-gray-500 tracking-wider mb-1">Registered Since</span>
                        <span class="font-semibold text-coffee-900 dark:text-white">{{ $customer->created_at->format('F j, Y (h:i A)') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right 2 Cols: Interactive Tabbed Panel -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Tab Selector Cards -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-2 shadow-sm flex items-center justify-between gap-1">
                <button onclick="switchTab('orders')" id="tabBtn-orders" class="tab-btn flex-grow py-3 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 bg-coffee-800 text-white shadow-warm">
                    <i class="fa-solid fa-receipt"></i> Order History ({{ $orders->total() }})
                </button>
                <button onclick="switchTab('addresses')" id="tabBtn-addresses" class="tab-btn flex-grow py-3 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 text-coffee-600 dark:text-gray-400 hover:bg-coffee-50 dark:hover:bg-gray-850">
                    <i class="fa-solid fa-map-location-dot"></i> Saved Addresses ({{ $customer->addresses->count() }})
                </button>
                <button onclick="switchTab('reviews')" id="tabBtn-reviews" class="tab-btn flex-grow py-3 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 text-coffee-600 dark:text-gray-400 hover:bg-coffee-50 dark:hover:bg-gray-850">
                    <i class="fa-solid fa-star"></i> Reviews ({{ $customer->reviews->count() }})
                </button>
            </div>

            <!-- Tab Contents container -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm min-h-[300px]">
                
                <!-- Tab: Orders History -->
                <div id="tabContent-orders" class="tab-panel space-y-4">
                    <h3 class="font-display text-lg font-bold text-coffee-950 dark:text-white border-b border-coffee-50 dark:border-gray-800 pb-3 mb-4">Past Orders</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                                    <th class="pb-3">Order No</th>
                                    <th class="pb-3">Placement Date</th>
                                    <th class="pb-3">Grand Total</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3">Payment</th>
                                    <th class="pb-3 pr-2 text-right">Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                                        <td class="py-4 font-mono font-bold text-coffee-800 dark:text-gray-300">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="py-4 text-xs text-coffee-600 dark:text-gray-400">
                                            {{ $order->created_at->format('M j, Y, g:i A') }}
                                        </td>
                                        <td class="py-4 font-extrabold text-coffee-950 dark:text-white">
                                            ₹{{ number_format($order->total, 2) }}
                                        </td>
                                        <td class="py-4">
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                @if($order->status === 'pending') bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-900
                                                @elseif($order->status === 'confirmed') bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900
                                                @elseif($order->status === 'processing') bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-900
                                                @elseif($order->status === 'shipped') bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-900
                                                @elseif($order->status === 'delivered') bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-900
                                                @else bg-rose-50 dark:bg-rose-950/20 text-rose-500 dark:text-rose-400 border border-rose-100 dark:border-rose-900
                                                @endif
                                            ">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-4">
                                            @if($order->payment_status === 'paid')
                                                <span class="px-2 py-0.5 rounded bg-green-100 dark:bg-green-955 text-green-800 dark:text-green-300 text-[10px] font-bold uppercase">Paid</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded bg-yellow-100 dark:bg-yellow-955 text-yellow-850 dark:text-yellow-400 text-[10px] font-bold uppercase">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-2 text-right">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-bakery-gold-600 hover:text-bakery-gold-700 font-bold text-xs"><i class="fa-solid fa-eye mr-1"></i> View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-coffee-400 italic">This customer has not placed any orders yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 pt-4 border-t border-coffee-50 dark:border-gray-800">
                        {{ $orders->links() }}
                    </div>
                </div>

                <!-- Tab: Saved Addresses -->
                <div id="tabContent-addresses" class="tab-panel hidden space-y-4">
                    <h3 class="font-display text-lg font-bold text-coffee-950 dark:text-white border-b border-coffee-50 dark:border-gray-800 pb-3 mb-4">Saved Shipping Locations</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($customer->addresses as $address)
                            <div class="p-4 bg-coffee-50/50 dark:bg-gray-950/30 rounded-2xl border border-coffee-100 dark:border-gray-800 relative flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2 py-0.5 bg-coffee-700 text-white rounded text-[10px] font-bold uppercase tracking-wider">{{ $address->label }}</span>
                                        @if($address->is_default)
                                            <span class="text-xxs font-bold text-bakery-gold-600 dark:text-bakery-gold-400 uppercase tracking-widest"><i class="fa-solid fa-circle-check"></i> Default</span>
                                        @endif
                                    </div>
                                    <p class="font-semibold text-coffee-900 dark:text-white text-xs mt-2">{{ $address->address_line_1 }}</p>
                                    @if($address->address_line_2)
                                        <p class="text-coffee-600 dark:text-gray-400 text-xs mt-1">{{ $address->address_line_2 }}</p>
                                    @endif
                                    <p class="text-coffee-500 dark:text-gray-500 text-xxs mt-0.5">{{ $address->city }}, {{ $address->state }} - {{ $address->zip_code }}</p>
                                    <p class="text-coffee-400 dark:text-gray-600 text-xxs mt-0.5">{{ $address->country }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-8 text-coffee-400 italic">No saved delivery addresses found for this account.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: Reviews -->
                <div id="tabContent-reviews" class="tab-panel hidden space-y-4">
                    <h3 class="font-display text-lg font-bold text-coffee-950 dark:text-white border-b border-coffee-50 dark:border-gray-800 pb-3 mb-4">Gourmet Reviews & Ratings</h3>
                    
                    <div class="space-y-4">
                        @forelse($customer->reviews as $review)
                            <div class="p-4 bg-coffee-50/50 dark:bg-gray-955 rounded-2xl border border-coffee-100/50 dark:border-gray-800/80">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-coffee-900 dark:text-white text-xs">
                                        @if($review->product)
                                            Reviewed: <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" class="text-bakery-gold-600 hover:underline">{{ $review->product->name }}</a>
                                        @else
                                            Reviewed: <span class="italic text-coffee-400">Deleted Product</span>
                                        @endif
                                    </span>
                                    <span class="text-xxs text-coffee-400 dark:text-gray-500">{{ $review->created_at->format('M j, Y') }}</span>
                                </div>

                                <div class="flex items-center gap-0.5 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        @else
                                            <i class="fa-regular fa-star text-coffee-200 dark:text-gray-700 text-xs"></i>
                                        @endif
                                    @endfor
                                </div>

                                <p class="text-xs text-coffee-700 dark:text-gray-300 italic leading-relaxed">
                                    "{{ $review->comment ?? 'No written comment, rating only.' }}"
                                </p>

                                <div class="mt-2 flex items-center justify-end">
                                    @if($review->is_approved)
                                        <span class="text-[10px] font-bold text-green-600 uppercase tracking-widest"><i class="fa-solid fa-circle-check"></i> Published</span>
                                    @else
                                        <span class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest"><i class="fa-solid fa-hourglass-half"></i> Pending Moderation</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-8 text-coffee-400 italic">This patron has not written any product reviews yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all tab panels
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = "tab-btn flex-grow py-3 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 text-coffee-600 dark:text-gray-400 hover:bg-coffee-50 dark:hover:bg-gray-850";
        });
        
        // Show selected panel
        const targetPanel = document.getElementById('tabContent-' + tabId);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }
        
        // Style selected button
        const targetBtn = document.getElementById('tabBtn-' + tabId);
        if (targetBtn) {
            targetBtn.className = "tab-btn flex-grow py-3 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 bg-coffee-800 text-white shadow-warm";
        }
    }
</script>
@endsection
