@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="font-display text-2xl font-bold">Gallery</h1>
    <a href="{{ route('admin.gallery.create') }}" class="px-4 py-2 bg-coffee-800 text-white rounded-xl text-sm font-bold">Add Image</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
@foreach($items as $item)
<div class="bg-white dark:bg-gray-900 rounded-2xl border p-4">
    <img src="{{ str_starts_with($item->image,'http') ? $item->image : asset('storage/'.$item->image) }}" class="w-full h-40 object-cover rounded-xl mb-2">
    <p class="font-bold text-sm">{{ $item->title }}</p>
    <div class="mt-2 flex gap-2">
        <a href="{{ route('admin.gallery.edit', $item) }}" class="text-gold text-xs font-bold">Edit</a>
        <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST">@csrf @method('DELETE')<button class="text-rose-600 text-xs">Delete</button></form>
    </div>
</div>
@endforeach
</div>
<div class="mt-4">{{ $items->links() }}</div>
@endsection
