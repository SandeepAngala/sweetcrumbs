@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Offer</h1>
<form method="POST" action="{{ route('admin.offers.update', $offer) }}" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border space-y-3 max-w-lg">
    @csrf @method('PUT')
    <input name="badge" value="{{ $offer->badge }}" class="w-full border rounded-xl px-3 py-2">
    <input name="title" value="{{ $offer->title }}" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="description" class="w-full border rounded-xl px-3 py-2" rows="3">{{ $offer->description }}</textarea>
    <input name="price" type="number" step="0.01" value="{{ $offer->price }}" class="w-full border rounded-xl px-3 py-2" required>
    <input name="compare_price" type="number" step="0.01" value="{{ $offer->compare_price }}" class="w-full border rounded-xl px-3 py-2">
    <input name="icon_classes" value="{{ $offer->icon_classes }}" class="w-full border rounded-xl px-3 py-2">
    <input name="button_link" value="{{ $offer->button_link }}" class="w-full border rounded-xl px-3 py-2">
    <input name="button_text" value="{{ $offer->button_text }}" class="w-full border rounded-xl px-3 py-2">
    <label><input type="checkbox" name="is_active" value="1" {{ $offer->is_active?'checked':'' }}> Active</label>
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Update</button>
</form>
@endsection
