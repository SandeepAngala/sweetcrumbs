<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center md:text-left">
        <h2 class="font-display text-2xl font-black text-coffee-800 dark:text-white leading-tight">Reset Password</h2>
        <p class="text-xs text-coffee-500 dark:text-gray-400 mt-2 font-medium">
            Enter your email and define your new secure password.
        </p>
    </div>

    <!-- Error Alerts (if any) -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/20 text-rose-800 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50 text-xs font-semibold space-y-1">
            <div class="flex items-center gap-1.5 font-bold">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i> Check your details:
            </div>
            <ul class="list-disc list-inside pl-1 text-[11px] font-medium space-y-0.5 opacity-90">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-envelope text-xs"></i>
            </div>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   placeholder=" "
                   autocomplete="username"
                   class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="email" 
                   class="absolute left-11 top-3.5 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Email Address
            </label>
        </div>

        <!-- Password Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-lock text-xs"></i>
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   placeholder=" "
                   autocomplete="new-password"
                   class="w-full pl-11 pr-11 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="password" 
                   class="absolute left-11 top-3.5 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                New Password
            </label>
            <!-- Visibility toggler -->
            <button type="button" 
                    onclick="togglePasswordVisibility('password', this)"
                    class="absolute inset-y-0 right-4 flex items-center text-coffee-400 hover:text-gold dark:text-gray-500 dark:hover:text-gold transition-colors">
                <i class="fa-solid fa-eye text-xs"></i>
            </button>
        </div>

        <!-- Confirm Password Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-circle-check text-xs"></i>
            </div>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   placeholder=" "
                   autocomplete="new-password"
                   class="w-full pl-11 pr-11 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="password_confirmation" 
                   class="absolute left-11 top-3.5 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Confirm Password
            </label>
            <!-- Visibility toggler -->
            <button type="button" 
                    onclick="togglePasswordVisibility('password_confirmation', this)"
                    class="absolute inset-y-0 right-4 flex items-center text-coffee-400 hover:text-gold dark:text-gray-500 dark:hover:text-gold transition-colors">
                <i class="fa-solid fa-eye text-xs"></i>
            </button>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                onclick="handleResetPasswordSubmit(this, event)"
                class="btn-premium w-full py-4 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm hover:shadow-luxury transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-98 border-t border-white/10">
            <span id="btnText">Reset Password</span>
            <span id="btnSpinner" class="hidden"><i class="fa-solid fa-spinner animate-spin"></i></span>
        </button>
    </form>

    <script>
        function togglePasswordVisibility(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fa-solid fa-eye-slash text-xs';
            } else {
                input.type = 'password';
                icon.className = 'fa-solid fa-eye text-xs';
            }
        }

        function handleResetPasswordSubmit(btn, e) {
            const form = document.getElementById('resetPasswordForm');
            if(form.checkValidity()) {
                document.getElementById('btnText').textContent = 'Updating...';
                document.getElementById('btnSpinner').classList.remove('hidden');
                btn.disabled = true;
                form.submit();
            }
        }
    </script>
</x-guest-layout>
