@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold mb-6">Add Gallery Item</h1>
<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border space-y-4 max-w-lg">
    @csrf
    <input name="title" placeholder="Title" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="description" placeholder="Description" class="w-full border rounded-xl px-3 py-2" rows="3"></textarea>
    <input name="category" placeholder="Category (cakes, breads...)" class="w-full border rounded-xl px-3 py-2" required>
    <input type="file" name="image" accept="image/*" required>
    <input type="number" name="sort_order" value="0" class="w-full border rounded-xl px-3 py-2">
    <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Save</button>
</form>
@endsection
