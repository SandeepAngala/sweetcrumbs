@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Support Inbox</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Review contact form inquiries, custom bakery bookings, and support messages</p>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="text-coffee-400 dark:text-gray-500 uppercase text-xxs font-bold tracking-wider border-b border-coffee-50 dark:border-gray-800">
                        <th class="pb-3 pl-4">Sender Info</th>
                        <th class="pb-3">Subject</th>
                        <th class="pb-3">Date Received</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 pr-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-coffee-50 dark:divide-gray-800">
                    @forelse($contacts as $message)
                        <tr class="hover:bg-coffee-50/50 dark:hover:bg-gray-950/20 transition-colors {{ !$message->is_read ? 'bg-coffee-50/20 dark:bg-gray-900/40 font-semibold' : '' }}">
                            <!-- Sender Info -->
                            <td class="py-4 pl-4">
                                <span class="text-coffee-900 dark:text-white block">{{ $message->name }}</span>
                                <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5">{{ $message->email }} @if($message->phone) &bull; {{ $message->phone }} @endif</span>
                            </td>
                            
                            <!-- Subject -->
                            <td class="py-4 text-xs text-coffee-800 dark:text-gray-250">
                                <span class="block truncate max-w-sm" title="{{ $message->subject }}">{{ $message->subject }}</span>
                                <span class="text-xxs text-coffee-400 dark:text-gray-500 block mt-0.5 line-clamp-1 max-w-sm font-normal">{{ $message->message }}</span>
                            </td>

                            <!-- Date Received -->
                            <td class="py-4 text-coffee-500 dark:text-gray-400 text-xs">
                                {{ $message->created_at ? $message->created_at->format('M j, Y, g:i A') : 'N/A' }}
                            </td>
                            
                            <!-- Read/Unread status -->
                            <td class="py-4">
                                @if($message->is_read)
                                    <span class="px-2.5 py-0.5 rounded-full bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 text-xxs font-bold uppercase tracking-wider border border-green-200 dark:border-green-800 font-normal">Read</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 text-xxs font-bold uppercase tracking-wider border border-blue-200 dark:border-blue-800">New Message</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 pr-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.contacts.show', $message->id) }}" class="p-2 border border-coffee-100 dark:border-gray-750 bg-white dark:bg-gray-800 rounded-lg text-coffee-600 dark:text-gray-300 hover:bg-coffee-50 hover:text-bakery-gold-600 shadow-sm" title="View Message"><i class="fa-solid fa-envelope-open"></i></a>
                                    
                                    <form action="{{ route('admin.contacts.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 border border-rose-100 dark:border-rose-950 bg-white dark:bg-gray-800 rounded-lg text-rose-500 hover:bg-rose-50 hover:text-rose-700 shadow-sm" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-coffee-400 dark:text-gray-500 italic">
                                Your inbox is empty! No customer support messages at the moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 border-t border-coffee-50 dark:border-gray-800 pt-4">
            {{ $contacts->links() }}
        </div>
    </div>

</div>
@endsection
