@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.contacts.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">View Message</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Detailed customer support request information</p>
        </div>
    </div>

    <!-- Message Detail Card -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm max-w-4xl space-y-6">
        
        <!-- Metadata Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-coffee-50 dark:border-gray-800 pb-6">
            <div>
                <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Sender Name</span>
                <span class="text-sm font-semibold text-coffee-900 dark:text-white">{{ $contact->name }}</span>
            </div>
            
            <div>
                <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Date & Time Received</span>
                <span class="text-sm font-semibold text-coffee-900 dark:text-white">
                    {{ $contact->created_at ? $contact->created_at->format('F d, Y, g:i A') : 'N/A' }}
                </span>
            </div>

            <div>
                <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Email Address</span>
                <a href="mailto:{{ $contact->email }}" class="text-sm font-semibold text-bakery-gold-600 hover:underline flex items-center gap-1">
                    {{ $contact->email }} <i class="fa-solid fa-envelope text-xxs"></i>
                </a>
            </div>

            <div>
                <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Phone Number</span>
                <span class="text-sm font-semibold text-coffee-900 dark:text-white">{{ $contact->phone ?? 'Not provided' }}</span>
            </div>

            <div class="md:col-span-2">
                <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-1">Subject</span>
                <span class="text-base font-bold text-coffee-950 dark:text-white">{{ $contact->subject }}</span>
            </div>
        </div>

        <!-- Message Body -->
        <div class="space-y-3">
            <span class="block text-xxs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500">Message Content</span>
            <div class="p-6 bg-coffee-50/50 dark:bg-gray-950/50 rounded-2xl border border-coffee-100 dark:border-gray-850 text-coffee-800 dark:text-gray-200 text-sm leading-relaxed whitespace-pre-line">
                {{ $contact->message }}
            </div>
        </div>

        <!-- Actions panel -->
        <div class="flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-coffee-50 dark:border-gray-800">
            <!-- Delete form -->
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-3.5 bg-rose-50 hover:bg-rose-100 dark:bg-gray-850 dark:hover:bg-gray-800 text-rose-500 dark:text-rose-400 border border-rose-100 dark:border-rose-950 font-bold rounded-2xl text-xs flex items-center gap-2 shadow-sm transition-transform active:scale-95">
                    <i class="fa-solid fa-trash-can"></i> Delete Message
                </button>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contacts.index') }}" class="px-5 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Back to Inbox
                </a>
                
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ rawurlencode($contact->subject) }}" class="px-5 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs flex items-center gap-2 shadow-warm transition-transform active:scale-95">
                    <i class="fa-solid fa-reply"></i> Reply via Email
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
