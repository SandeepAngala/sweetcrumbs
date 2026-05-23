@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Gallery Item</h1>
<form method="POST" action="{{ route('admin.gallery.update', $item) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border space-y-4 max-w-lg">
    @csrf @method('PUT')
    <input name="title" value="{{ $item->title }}" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="3">{{ $item->description }}</textarea>
    <input name="category" value="{{ $item->category }}" class="w-full border rounded-xl px-3 py-2" required>
    <input type="file" name="image" accept="image/*">
    <input type="number" name="sort_order" value="{{ $item->sort_order }}" class="w-full border rounded-xl px-3 py-2">
    <label><input type="checkbox" name="is_active" value="1" {{ $item->is_active?'checked':'' }}> Active</label>
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Update</button>
</form>
@endsection
