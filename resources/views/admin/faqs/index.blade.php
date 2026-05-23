@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="font-display text-2xl font-bold text-coffee-900 dark:text-white">FAQs</h1>
    <a href="{{ route('admin.faqs.create') }}" class="px-4 py-2 bg-coffee-800 text-white rounded-xl text-sm font-bold">Add FAQ</a>
</div>
@if(session('success'))<div class="mb-4 p-3 bg-green-50 text-green-800 rounded-xl">{{ session('success') }}</div>@endif
<div class="bg-white dark:bg-gray-900 rounded-2xl border overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-coffee-50 dark:bg-gray-800"><tr><th class="p-3 text-left">Question</th><th class="p-3 text-left">Category</th><th class="p-3">Active</th><th class="p-3"></th></tr></thead>
        <tbody>
        @foreach($faqs as $faq)
        <tr class="border-t border-coffee-100 dark:border-gray-800">
            <td class="p-3">{{ \Illuminate\Support\Str::limit($faq->question, 60) }}</td>
            <td class="p-3">{{ $faq->category }}</td>
            <td class="p-3">{{ $faq->is_active ? 'Yes' : 'No' }}</td>
            <td class="p-3 text-right space-x-2">
                <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-gold font-bold">Edit</a>
                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline">@csrf @method('DELETE')<button type="submit" class="text-rose-600">Delete</button></form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="p-3">{{ $faqs->links() }}</div>
</div>
@endsection
