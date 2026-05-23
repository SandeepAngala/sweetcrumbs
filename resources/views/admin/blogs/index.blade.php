@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Blog Magazine</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Publish recipes, backing guides, and boutique stories</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="px-5 py-3 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm flex items-center justify-center gap-2 transition-all">
            <i class="fa-solid fa-plus"></i> Write New Article
        </a>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Cover & Title</th>
                        <th class="pb-3">Author</th>
                        <th class="pb-3">Category</th>
                        <th class="pb-3">Date Published</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @foreach($blogs as $blog)
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors">
                            <td class="py-4 pl-4 flex items-center gap-3">
                                <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-16 h-12 object-cover rounded-lg border border-coffee-100 dark:border-gray-700">
                                <div>
                                    <span class="font-semibold text-coffee-900 dark:text-white block max-w-sm truncate">{{ $blog->title }}</span>
                                    <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5">{{ $blog->excerpt ?? 'No snippet text.' }}</span>
                                </div>
                            </td>
                            
                            <td class="py-4 text-coffee-600 dark:text-gray-300 font-semibold text-xs">
                                {{ $blog->author->name ?? 'Chef Baker' }}
                            </td>
                            
                            <td class="py-4">
                                <span class="px-2 py-0.5 rounded bg-coffee-50 dark:bg-gray-800 border border-coffee-100 dark:border-gray-700 text-coffee-700 dark:text-coffee-300 text-xxs font-extrabold uppercase">
                                    {{ $blog->category ?? 'Baking Guide' }}
                                </span>
                            </td>

                            <td class="py-4 text-coffee-500 dark:text-gray-400 text-xs">
                                {{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('M j, Y, g:i A') : 'Not published' }}
                            </td>
                            
                            <td class="py-4">
                                @if($blog->is_published)
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800 font-semibold">Published</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-yellow-50 dark:bg-yellow-950/20 text-yellow-600 dark:text-yellow-400 text-xxs font-bold uppercase tracking-wider border border-yellow-200 dark:border-yellow-800 font-semibold">Draft</span>
                                @endif
                            </td>

                            <td class="py-4 pr-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="p-2 border border-coffee-100 dark:border-gray-750 bg-white dark:bg-gray-800 rounded-lg text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 hover:text-bakery-gold-600 shadow-sm" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
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
            {{ $blogs->links() }}
        </div>
    </div>

</div>
@endsection
