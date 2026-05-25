@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Customer Database</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Oversee customer accounts, loyalty points, and ordering frequencies</p>
        </div>
        
        <!-- Search filter placeholder for UX/UI excellence -->
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-coffee-400 dark:text-gray-500">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </span>
            <input type="text" id="customerSearchInput" placeholder="Search customers..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-white dark:bg-gray-900 border border-coffee-200 dark:border-gray-800 text-xs font-semibold text-coffee-800 dark:text-gray-300 placeholder-coffee-400 focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 focus:border-transparent transition-all">
        </div>
    </div>

    <!-- Quick Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Total Patrons</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">{{ $customers->total() }}</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/20 text-amber-500 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Active Tiers</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">4 Loyalty Levels</span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-award"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-coffee-100 dark:border-gray-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-coffee-400 dark:text-gray-500 uppercase tracking-wider block">Sweet Loyalty</span>
                <span class="text-2xl font-black text-coffee-900 dark:text-white mt-1 block">Points Program</span>
            </div>
            <div class="w-12 h-12 bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>
        </div>
    </div>

    <!-- Customer Table Directory -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm" id="customerTable">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Customer Details</th>
                        <th class="pb-3">Contact</th>
                        <th class="pb-3">Sweet Loyalty Level</th>
                        <th class="pb-3 text-center">Orders</th>
                        <th class="pb-3">Joined Date</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @forelse($customers as $cust)
                        @php
                            $points = $cust->loyalty_points ?? 0;
                            // Loyalty Tier logic
                            if ($points >= 600) {
                                $tier = 'Pastry Master';
                                $tierClass = 'bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900';
                                $tierIcon = 'fa-solid fa-crown';
                            } elseif ($points >= 300) {
                                $tier = 'Butter Elite';
                                $tierClass = 'bg-coffee-100 dark:bg-coffee-950/30 text-coffee-800 dark:text-coffee-300 border border-coffee-200 dark:border-coffee-900';
                                $tierIcon = 'fa-solid fa-medal';
                            } elseif ($points >= 100) {
                                $tier = 'Honey Enthusiast';
                                $tierClass = 'bg-orange-50 dark:bg-orange-950/20 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-900';
                                $tierIcon = 'fa-solid fa-star';
                            } else {
                                $tier = 'Sugar Apprentice';
                                $tierClass = 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
                                $tierIcon = 'fa-solid fa-cookie';
                            }
                        @endphp
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors customer-row">
                            <!-- Name & Avatar -->
                            <td class="py-4 pl-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-coffee-700 to-coffee-900 flex items-center justify-center text-white font-bold border border-coffee-200 text-xs shadow-sm uppercase">
                                    @if($cust->avatar)
                                        <img src="{{ $cust->avatar }}" alt="{{ $cust->name }}" class="w-full h-full object-cover rounded-full">
                                    @else
                                        {{ substr($cust->name, 0, 2) }}
                                    @endif
                                </div>
                                <div>
                                    <span class="font-semibold text-coffee-900 dark:text-white block customer-name">{{ $cust->name }}</span>
                                    <span class="text-xxs font-mono text-coffee-400 dark:text-gray-500">ID: #{{ str_pad($cust->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </td>

                            <!-- Contact info -->
                            <td class="py-4 text-xs">
                                <span class="text-coffee-800 dark:text-gray-300 font-medium block customer-email">{{ $cust->email }}</span>
                                @if($cust->phone)
                                    <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5"><i class="fa-solid fa-phone text-xxs mr-1"></i> {{ $cust->phone }}</span>
                                @else
                                    <span class="text-xxs text-coffee-300 dark:text-gray-600 block mt-0.5 italic">No phone attached</span>
                                @endif
                            </td>

                            <!-- Loyalty tier level -->
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider flex items-center gap-1.5 {{ $tierClass }}">
                                        <i class="{{ $tierIcon }} text-[10px]"></i> {{ $tier }}
                                    </span>
                                    <span class="text-xxs font-bold text-coffee-400 dark:text-gray-500 font-mono">({{ $points }} points)</span>
                                </div>
                            </td>

                            <!-- Total Orders placed -->
                            <td class="py-4 text-center">
                                <span class="px-3 py-1 bg-coffee-50 dark:bg-gray-800 text-coffee-800 dark:text-white rounded-xl text-xs font-extrabold border border-coffee-100 dark:border-gray-700">
                                    {{ $cust->orders_count ?? 0 }}
                                </span>
                            </td>

                            <!-- Joined Date -->
                            <td class="py-4 text-xs text-coffee-600 dark:text-gray-400 font-medium">
                                {{ $cust->created_at->format('M j, Y') }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pr-4 text-right">
                                <a href="{{ route('admin.customers.show', $cust->id) }}" class="px-3 py-2 border border-coffee-100 dark:border-gray-800 bg-white dark:bg-gray-800 text-coffee-700 dark:text-white rounded-xl text-xs font-bold shadow-sm hover:bg-coffee-50 inline-flex items-center justify-center gap-1.5 transition-colors">
                                    <i class="fa-solid fa-address-card"></i> Dossier
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-coffee-400 italic">No customers registered under this bakery account.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Links -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('customerSearchInput');
        if (!searchInput) return;

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('.customer-row');

            rows.forEach(row => {
                const nameText = row.querySelector('.customer-name').textContent.toLowerCase();
                const emailText = row.querySelector('.customer-email').textContent.toLowerCase();

                if (nameText.includes(filter) || emailText.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
