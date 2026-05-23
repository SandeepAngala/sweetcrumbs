@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action bar -->
    <div class="flex items-center gap-2 border-b border-coffee-100 dark:border-gray-800 pb-5">
        <a href="{{ route('admin.coupons.index') }}" class="text-coffee-400 hover:text-coffee-600 dark:text-gray-400 mr-2"><i class="fa-solid fa-arrow-left text-lg"></i></a>
        <div>
            <h1 class="font-display text-3xl font-bold text-coffee-950 dark:text-white">Edit Coupon</h1>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1">Update details for coupon code "{{ $coupon->code }}"</p>
        </div>
    </div>

    <!-- Coupon Form -->
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="space-y-6 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-coffee-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code -->
                <div>
                    <label for="code" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Coupon Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white font-mono font-bold focus:outline-none focus:ring-2 focus:ring-bakery-gold-400">
                    @error('code')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Discount Type</label>
                    <select name="type" id="type" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 font-semibold">
                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                        <option value="percent" {{ old('type', $coupon->type) === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Value -->
                <div>
                    <label for="value" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Discount Value</label>
                    <input type="number" step="0.01" name="value" id="value" value="{{ old('value', $coupon->value) }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 font-medium">
                    @error('value')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Min Order Amount -->
                <div>
                    <label for="min_order_amount" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Minimum Order Amount (₹)</label>
                    <input type="number" step="0.01" name="min_order_amount" id="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 font-medium">
                    @error('min_order_amount')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Max Discount -->
                <div>
                    <label for="max_discount" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Maximum Discount Limit (₹, For percent only)</label>
                    <input type="number" step="0.01" name="max_discount" id="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 font-medium">
                    @error('max_discount')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Usage Limit -->
                <div>
                    <label for="usage_limit" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Usage Limit (per code)</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 font-medium">
                    @error('usage_limit')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Starts At -->
                <div>
                    <label for="starts_at" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Starts At</label>
                    <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at', $coupon->starts_at ? \Carbon\Carbon::parse($coupon->starts_at)->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 text-sm font-semibold">
                    @error('starts_at')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expires At -->
                <div>
                    <label for="expires_at" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Expires At</label>
                    <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at', $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl bg-coffee-50/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-850 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 text-sm font-semibold">
                    @error('expires_at')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Is Active Toggle -->
            <div class="flex items-center pt-2">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-coffee-100 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-bakery-gold-500"></div>
                    <span class="ml-3 text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400">Coupon Active</span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-6 border-t border-coffee-50 dark:border-gray-800">
                <a href="{{ route('admin.coupons.index') }}" class="px-6 py-3.5 border border-coffee-200 dark:border-gray-700 text-coffee-800 dark:text-white font-bold rounded-2xl text-xs hover:bg-coffee-50 dark:hover:bg-gray-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm transition-transform active:scale-95">
                    Save Changes
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
