@extends('layouts.admin')
@section('content')
<form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border space-y-3 max-w-lg">
    @csrf
    <input name="name" placeholder="Name" class="w-full border rounded-xl px-3 py-2" required>
    <input name="role" placeholder="Role" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="bio" placeholder="Bio" class="w-full border rounded-xl px-3 py-2" rows="4"></textarea>
    <input type="file" name="image" accept="image/*">
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Save</button>
</form>
@endsection
