@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold mb-6">Add Homepage Offer</h1>
<form method="POST" action="{{ route('admin.offers.store') }}" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border space-y-3 max-w-lg">
    @csrf
    <input name="badge" placeholder="Badge text" class="w-full border rounded-xl px-3 py-2">
    <input name="title" placeholder="Title" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="description" placeholder="Description" class="w-full border rounded-xl px-3 py-2" rows="3"></textarea>
    <input name="price" type="number" step="0.01" placeholder="Price" class="w-full border rounded-xl px-3 py-2" required>
    <input name="compare_price" type="number" step="0.01" placeholder="Compare at price" class="w-full border rounded-xl px-3 py-2">
    <input name="icon_classes" placeholder="Icon classes (fa-mug-hot fa-leaf)" class="w-full border rounded-xl px-3 py-2">
    <input name="button_link" placeholder="Button link" class="w-full border rounded-xl px-3 py-2">
    <input name="button_text" value="ORDER COMBO PAIR" class="w-full border rounded-xl px-3 py-2">
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Save</button>
</form>
@endsection
