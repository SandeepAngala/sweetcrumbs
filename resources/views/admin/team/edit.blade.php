@extends('layouts.admin')
@section('content')
<form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border space-y-3 max-w-lg">
    @csrf @method('PUT')
    <input name="name" value="{{ $member->name }}" class="w-full border rounded-xl px-3 py-2" required>
    <input name="role" value="{{ $member->role }}" class="w-full border rounded-xl px-3 py-2" required>
    <textarea name="bio" class="w-full border rounded-xl px-3 py-2" rows="4">{{ $member->bio }}</textarea>
    <input type="file" name="image" accept="image/*">
    <button class="px-6 py-2 bg-coffee-800 text-white rounded-xl font-bold">Update</button>
</form>
@endsection
