@extends('layouts.dashboard')

@section('title', 'Profile Settings')

@section('dashboard_content')
<div class="space-y-8" data-aos="fade-left">
    
    <!-- Header Section -->
    <div class="border-b border-coffee-100 dark:border-gray-800 pb-5">
        <h1 class="font-display text-3xl font-extrabold text-coffee-950 dark:text-white">Profile Settings</h1>
        <p class="text-sm text-coffee-600 dark:text-gray-400 mt-1">Manage your account information and password</p>
    </div>

    <!-- Edit Profile Form -->
    <form action="{{ route('dashboard.profile.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Personal Info Section -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-8 shadow-warm">
            <h2 class="font-display text-xl font-bold text-coffee-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fa-solid fa-user text-bakery-gold-500"></i> Personal Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all font-medium">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Disabled) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-coffee-400 dark:text-gray-500 mb-2">Email Address (Cannot change)</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3.5 rounded-2xl bg-coffee-100/50 dark:bg-gray-950/50 border border-coffee-100 dark:border-gray-800 text-coffee-400 dark:text-gray-500 cursor-not-allowed font-mono">
                    <span class="text-xxs text-coffee-400 dark:text-gray-500 mt-1.5 block">Contact customer support if you need to update your email.</span>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="+91 98765 43210" class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all font-medium">
                    @error('phone')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Delivery Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Primary Address</label>
                    <textarea name="address" id="address" rows="3" placeholder="Enter your full home or office address..." class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all font-medium resize-none">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Security / Password Section -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-coffee-100 dark:border-gray-700 p-8 shadow-warm">
            <h2 class="font-display text-xl font-bold text-coffee-900 dark:text-white mb-2 flex items-center gap-2">
                <i class="fa-solid fa-lock text-bakery-gold-500"></i> Change Password
            </h2>
            <p class="text-xs text-coffee-500 dark:text-gray-400 mb-6">Leave password fields blank if you do not wish to change it.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all">
                    @error('current_password')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all">
                    @error('new_password')
                        <p class="text-xs text-rose-500 mt-1.5 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="new_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-coffee-600 dark:text-gray-400 mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-900/50 border border-coffee-100 dark:border-gray-700 text-coffee-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-bakery-gold-400 dark:focus:ring-bakery-gold-500 transition-all">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4">
            <button type="submit" class="px-8 py-4 bg-coffee-800 hover:bg-coffee-900 dark:bg-coffee-700 dark:hover:bg-coffee-600 text-white font-bold rounded-2xl shadow-warm hover:-translate-y-0.5 active:scale-95 transition-all text-sm">
                Save Profile Changes
            </button>
        </div>

    </form>
</div>
@endsection
