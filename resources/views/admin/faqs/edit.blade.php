@extends('layouts.admin')
@section('content')
<h1 class="font-display text-2xl font-bold mb-6">Edit FAQ</h1>
<form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border space-y-4 max-w-2xl">
    @csrf @method('PUT')
    <div><label class="block text-sm font-bold mb-1">Category</label><input name="category" value="{{ old('category',$faq->category) }}" class="w-full rounded-xl border px-3 py-2" required></div>
    <div><label class="block text-sm font-bold mb-1">Question</label><input name="question" value="{{ old('question',$faq->question) }}" class="w-full rounded-xl border px-3 py-2" required></div>
    <div><label class="block text-sm font-bold mb-1">Answer</label><textarea name="answer" rows="5" class="w-full rounded-xl border px-3 py-2" required>{{ old('answer',$faq->answer) }}</textarea></div>
    <div><label class="block text-sm font-bold mb-1">Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$faq->sort_order) }}" class="w-full rounded-xl border px-3 py-2"></div>
    <label><input type="checkbox" name="is_active" value="1" {{ $faq->is_active ? 'checked' : '' }}> Active</label>
    <button type="submit" class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Update</button>
</form>
@endsection
