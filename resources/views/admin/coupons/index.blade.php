@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Discount Coupons</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Manage sweet promotions, discount codes, and user offers</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="px-5 py-3 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm flex items-center justify-center gap-2 transition-all">
            <i class="fa-solid fa-plus"></i> Add New Coupon
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Coupon Code</th>
                        <th class="pb-3">Type</th>
                        <th class="pb-3">Value</th>
                        <th class="pb-3">Min Order</th>
                        <th class="pb-3">Used / Limit</th>
                        <th class="pb-3">Duration</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @foreach($coupons as $coupon)
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                            <td class="py-4 pl-4 font-mono font-bold text-bakery-gold-600 dark:text-bakery-gold-400 text-sm">
                                {{ $coupon->code }}
                            </td>
                            
                            <td class="py-4">
                                <span class="px-2 py-0.5 rounded text-xxs font-bold uppercase tracking-wider
                                    @if($coupon->type === 'percent') bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800
                                    @else bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800
                                    @endif
                                ">
                                    {{ $coupon->type }}
                                </span>
                            </td>
                            
                            <td class="py-4 font-extrabold text-coffee-950 dark:text-white">
                                @if($coupon->type === 'percent')
                                    {{ number_format($coupon->value, 0) }}%
                                @else
                                    ₹{{ number_format($coupon->value, 2) }}
                                @endif
                            </td>
                            
                            <td class="py-4 text-coffee-600 dark:text-gray-300 font-medium">
                                ₹{{ number_format($coupon->min_order_amount ?? 0, 2) }}
                            </td>

                            <td class="py-4 text-coffee-500 dark:text-gray-400 text-xs">
                                <span class="font-bold">{{ $coupon->used_count }}</span> / {{ $coupon->usage_limit ?? '∞' }}
                            </td>

                            <td class="py-4 text-coffee-600 dark:text-gray-300 text-xs">
                                <span class="font-semibold">Starts:</span> {{ \Carbon\Carbon::parse($coupon->starts_at)->format('M j, Y') }}<br>
                                <span class="font-semibold text-rose-500">Expires:</span> {{ \Carbon\Carbon::parse($coupon->expires_at)->format('M j, Y') }}
                            </td>
                            
                            <td class="py-4">
                                @if($coupon->is_active && \Carbon\Carbon::parse($coupon->expires_at)->isAfter(now()))
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800">Active</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 text-xxs font-bold uppercase tracking-wider border border-yellow-200 dark:border-yellow-800">Inactive/Expired</span>
                                @endif
                            </td>

                            <td class="py-4 pr-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="p-2 border border-coffee-100 dark:border-gray-750 bg-white dark:bg-gray-800 rounded-lg text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 hover:text-bakery-gold-600 shadow-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 border border-rose-100 dark:border-rose-950 bg-white dark:bg-gray-800 rounded-lg text-rose-500 hover:bg-rose-50 hover:text-rose-700 shadow-sm" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $coupons->links() }}
        </div>
    </div>

</div>
@endsection
