@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Customer Reviews</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Approve or reject customer-submitted ratings and comments on products</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Customer</th>
                        <th class="pb-3">Product</th>
                        <th class="pb-3">Rating</th>
                        <th class="pb-3 max-w-sm">Comment</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                            <!-- Customer Info -->
                            <td class="py-4 pl-4">
                                <span class="font-semibold text-coffee-900 dark:text-white block">{{ $review->user->name ?? 'Anonymous Customer' }}</span>
                                <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5">{{ $review->user->email ?? 'no-email@customer.com' }}</span>
                            </td>

                            <!-- Product Info -->
                            <td class="py-4 font-semibold text-coffee-800 dark:text-gray-250 text-xs">
                                @if($review->product)
                                    <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" class="hover:text-bakery-gold-600 transition-colors flex items-center gap-2">
                                        @if(!empty($review->product->images) && is_array($review->product->images))
                                            <img src="{{ $review->product->images[0] }}" alt="Product Image" class="w-8 h-8 rounded-lg object-cover border border-coffee-50 dark:border-gray-700">
                                        @elseif($review->product->image)
                                            <img src="{{ $review->product->image }}" alt="Product Image" class="w-8 h-8 rounded-lg object-cover border border-coffee-50 dark:border-gray-700">
                                        @endif
                                        <span>{{ $review->product->name }}</span>
                                    </a>
                                @else
                                    <span class="text-coffee-400 italic">Deleted Product</span>
                                @endif
                            </td>
                            
                            <!-- Rating -->
                            <td class="py-4">
                                <div class="flex items-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        @else
                                            <i class="fa-regular fa-star text-coffee-200 dark:text-gray-700 text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>

                            <!-- Comment -->
                            <td class="py-4 text-xs text-coffee-600 dark:text-gray-300 max-w-sm">
                                <p class="line-clamp-2 leading-relaxed" title="{{ $review->comment }}">
                                    {{ $review->comment ?? 'No written comment, only rating.' }}
                                </p>
                            </td>
                            
                            <!-- Status badge -->
                            <td class="py-4">
                                @if($review->is_approved)
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800">Approved</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 text-xxs font-bold uppercase tracking-wider border border-yellow-200 dark:border-yellow-800">Pending Review</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pr-4 text-right">
                                <div class="flex items-center justify-end gap-2.5">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-xxs shadow-sm transition-transform active:scale-95 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check"></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-rose-500 dark:text-rose-400 border border-rose-200 dark:border-rose-950 font-bold rounded-xl text-xxs shadow-sm transition-transform active:scale-95 flex items-center gap-1">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-coffee-400 dark:text-gray-500 italic">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection
