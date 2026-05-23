@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <h1 class="font-display text-2xl font-bold text-coffee-900">Store Settings</h1>

    @if(session('success'))
        <div class="bg-green-50 text-green-800 p-3 rounded-xl">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="bg-white rounded-2xl border border-coffee-100 p-6 space-y-4">
        @csrf
        @method('PUT')
        @php $i = 0; @endphp
        @foreach($settings as $group => $items)
            <h2 class="font-semibold text-coffee-800 capitalize">{{ $group }}</h2>
            @foreach($items as $setting)
            <div>
                <label class="block text-sm text-coffee-600 mb-1">{{ $setting->key }}</label>
                <input type="hidden" name="settings[{{ $i }}][key]" value="{{ $setting->key }}">
                <input type="hidden" name="settings[{{ $i }}][group]" value="{{ $setting->group }}">
                <input type="hidden" name="settings[{{ $i }}][type]" value="{{ $setting->type }}">
                <input name="settings[{{ $i }}][value]" value="{{ $setting->value }}" class="w-full rounded-xl border-coffee-200">
                @php $i++; @endphp
            </div>
            @endforeach
        @endforeach
        <button type="submit" class="px-6 py-2 bg-coffee-800 text-white rounded-xl">Save Settings</button>
    </form>
</div>
@endsection
