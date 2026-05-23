@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Order Management</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Review orders, update kitchen progress, and oversee shipping</p>
        </div>
        
        <!-- Quick Status Filter -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl bg-white dark:bg-gray-900 border border-coffee-200 dark:border-gray-800 text-xs font-bold text-coffee-800 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-bakery-gold-400">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>In Kitchen</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Out for Delivery</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>

    <!-- Orders Table Box -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Order No</th>
                        <th class="pb-3">Customer</th>
                        <th class="pb-3">Date</th>
                        <th class="pb-3">Delivery Date</th>
                        <th class="pb-3">Total</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Payment</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @forelse($orders as $order)
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                            <td class="py-4 pl-4 font-mono font-bold text-coffee-800 dark:text-gray-300">
                                {{ $order->order_number }}
                            </td>
                            
                            <td class="py-4 font-semibold text-coffee-900 dark:text-white">
                                {{ $order->user->name ?? 'Guest User' }}
                                <span class="text-xxs font-normal text-coffee-400 dark:text-gray-500 block mt-0.5">{{ $order->user->email ?? '' }}</span>
                            </td>
                            
                            <td class="py-4 text-coffee-500 dark:text-gray-400">
                                {{ $order->created_at->format('M j, Y') }}
                            </td>
                            
                            <td class="py-4 text-coffee-600 dark:text-gray-300 font-medium">
                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('M j, Y') }}
                                <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5">{{ $order->delivery_time_slot }}</span>
                            </td>

                            <td class="py-4 font-extrabold text-coffee-950 dark:text-white">
                                ₹{{ number_format($order->total, 2) }}
                            </td>

                            <td class="py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider
                                    @if($order->status === 'pending') bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-900
                                    @elseif($order->status === 'confirmed') bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-900
                                    @elseif($order->status === 'processing') bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-900 animate-pulse
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
                                    <span class="px-2 py-0.5 rounded bg-green-100 text-green-800 text-[10px] font-bold uppercase">Paid</span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-850 text-[10px] font-bold uppercase">Pending</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800 text-[10px] font-bold uppercase">{{ $order->payment_status }}</span>
                                @endif
                            </td>

                            <td class="py-4 pr-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-4 py-2 border border-coffee-100 dark:border-gray-800 bg-white dark:bg-gray-800 text-coffee-700 dark:text-white rounded-xl text-xs font-bold shadow-sm hover:bg-coffee-50 flex items-center justify-center gap-1.5 inline-flex transition-colors">
                                    <i class="fa-solid fa-gears"></i> Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-coffee-400 italic">No orders found matching this query.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection
