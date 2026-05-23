@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <h1 class="font-display text-2xl font-bold text-coffee-900">Inventory Management</h1>

    <div class="bg-white rounded-2xl border border-coffee-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-coffee-50">
                <tr>
                    <th class="text-left p-3">Product</th>
                    <th class="text-left p-3">SKU</th>
                    <th class="text-left p-3">Stock</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Adjust</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-t border-coffee-50">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->sku }}</td>
                    <td class="p-3 font-semibold {{ $product->stock <= 5 ? 'text-red-600' : '' }}">{{ $product->stock }}</td>
                    <td class="p-3">{{ $product->status }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.inventory.adjust', $product) }}" class="flex gap-2 items-center">
                            @csrf
                            <input type="number" name="quantity_change" placeholder="+/-" class="w-16 rounded border px-2 py-1 text-xs" required />
                            <select name="type" class="rounded border px-2 py-1 text-xs">
                                <option value="in">Stock In</option>
                                <option value="out">Stock Out</option>
                                <option value="adjustment">Adjust</option>
                            </select>
                            <button type="submit" class="text-xs bg-coffee-800 text-white px-2 py-1 rounded">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $products->links() }}</div>
    </div>
</div>
@endsection
