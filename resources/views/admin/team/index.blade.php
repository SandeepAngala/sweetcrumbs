@extends('layouts.admin')
@section('content')
<div class="flex justify-between mb-6">
    <h1 class="text-2xl font-bold">Team Members</h1>
    <a href="{{ route('admin.team.create') }}" class="px-4 py-2 bg-coffee-800 text-white rounded-xl text-sm font-bold">Add Member</a>
</div>
@foreach($members as $member)
<div class="bg-white dark:bg-gray-900 border rounded-2xl p-4 mb-3 flex justify-between items-center">
    <div><strong>{{ $member->name }}</strong> — {{ $member->role }}</div>
    <div><a href="{{ route('admin.team.edit',$member) }}" class="text-gold font-bold">Edit</a></div>
</div>
@endforeach
{{ $members->links() }}
@endsection
