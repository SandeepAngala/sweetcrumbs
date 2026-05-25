@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Product Inventory</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Manage and track your signature recipes and stock levels</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-3 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm flex items-center justify-center gap-2 transition-all">
            <i class="fa-solid fa-plus"></i> Add New Product
        </a>
    </div>

    <!-- Product Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Product Details</th>
                        <th class="pb-3">Category</th>
                        <th class="pb-3">Price</th>
                        <th class="pb-3">Stock</th>
                        <th class="pb-3">Badges</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @foreach($products as $prod)
                        @php
                            $images = is_string($prod->images) ? json_decode($prod->images, true) : $prod->images;
                            $primaryImage = $images[0] ?? 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=200';
                        @endphp
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                            <td class="py-4 pl-4 flex items-center gap-3">
                                <img src="{{ $primaryImage }}" alt="{{ $prod->name }}" class="w-12 h-12 object-cover rounded-xl border border-coffee-100 dark:border-gray-700">
                                <div>
                                    <span class="font-semibold text-coffee-900 dark:text-white block">{{ $prod->name }}</span>
                                    <span class="text-xxs font-mono text-coffee-400 dark:text-gray-500">SKU: {{ $prod->sku ?? 'N/A' }}</span>
                                </div>
                            </td>
                            
                            <td class="py-4 text-coffee-600 dark:text-gray-300 font-medium">
                                {{ $prod->category->name ?? 'House Special' }}
                            </td>
                            
                            <td class="py-4 font-bold text-coffee-950 dark:text-white">
                                @if($prod->discount_price)
                                    <span class="text-bakery-gold-600">₹{{ number_format($prod->discount_price, 2) }}</span>
                                    <span class="text-xs text-coffee-400 line-through block font-normal">₹{{ number_format($prod->price, 2) }}</span>
                                @else
                                    ₹{{ number_format($prod->price, 2) }}
                                @endif
                            </td>
                            
                            <td class="py-4">
                                @if($prod->stock < 5)
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-50 dark:bg-rose-950/20 text-rose-500 font-extrabold text-xxs border border-rose-200 dark:border-rose-900">{{ $prod->stock }} Left</span>
                                @else
                                    <span class="text-coffee-700 dark:text-gray-300 font-semibold">{{ $prod->stock }} units</span>
                                @endif
                            </td>
                            
                            <td class="py-4 space-y-1">
                                @if($prod->is_featured)
                                    <span class="inline-block px-2 py-0.5 bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 text-[10px] font-bold rounded-full uppercase tracking-wider border border-amber-200 dark:border-amber-900">Featured</span>
                                @endif
                                @if($prod->is_trending)
                                    <span class="inline-block px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold rounded-full uppercase tracking-wider border border-indigo-200 dark:border-indigo-900">Trending</span>
                                @endif
                                @if($prod->is_bestseller)
                                    <span class="inline-block px-2 py-0.5 bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 text-[10px] font-bold rounded-full uppercase tracking-wider border border-purple-200 dark:border-purple-900 font-semibold">Bestseller</span>
                                @endif
                            </td>
                            
                            <td class="py-4">
                                @if($prod->status === 'active')
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800">Active</span>
                                @elseif($prod->status === 'inactive')
                                    <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 text-xxs font-bold uppercase tracking-wider border border-yellow-200 dark:border-yellow-800">Inactive</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 text-xxs font-bold uppercase tracking-wider border border-gray-300 dark:border-gray-700">Draft</span>
                                @endif
                            </td>

                            <td class="py-4 pr-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $prod->id) }}" class="p-2 border border-coffee-100 dark:border-gray-750 bg-white dark:bg-gray-800 rounded-lg text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 hover:text-bakery-gold-600 shadow-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('admin.products.destroy', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
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

        <!-- Custom Pagination Links -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
