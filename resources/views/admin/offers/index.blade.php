@extends('layouts.admin')
@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Homepage Combo Offers</h1>
    <a href="{{ route('admin.offers.create') }}" class="px-4 py-2 bg-coffee-800 text-white rounded-xl text-sm font-bold">Add Offer</a>
</div>
<table class="w-full bg-white dark:bg-gray-900 rounded-2xl border text-sm">
    <thead><tr class="border-b"><th class="p-3 text-left">Title</th><th class="p-3">Price</th><th class="p-3"></th></tr></thead>
    <tbody>
    @foreach($offers as $offer)
    <tr class="border-b"><td class="p-3">{{ $offer->title }}</td><td class="p-3">₹{{ $offer->price }}</td>
    <td class="p-3"><a href="{{ route('admin.offers.edit',$offer) }}" class="text-gold font-bold">Edit</a>
    <form action="{{ route('admin.offers.destroy',$offer) }}" method="POST" class="inline">@csrf @method('DELETE')<button class="text-rose-600 ml-2">Delete</button></form></td></tr>
    @endforeach
    </tbody>
</table>
{{ $offers->links() }}
@endsection
