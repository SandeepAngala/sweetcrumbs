<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center md:text-left">
        <h2 class="font-display text-2xl font-black text-coffee-800 dark:text-white leading-tight">Recover Password</h2>
        <p class="text-xs text-coffee-500 dark:text-gray-400 mt-2 font-medium">
            Enter your registered email below to receive a password reset link.
        </p>
    </div>

    <!-- Session Status Alert -->
    <x-auth-session-status class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50 text-xs font-semibold flex items-center gap-2" :status="session('status')" />

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

    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="space-y-6">
        @csrf

        <!-- Email Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-envelope text-xs"></i>
            </div>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder=" "
                   class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="email" 
                   class="absolute left-11 top-3.5 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Email Address
            </label>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-4">
            <button type="submit" 
                    onclick="handleForgotPasswordSubmit(this, event)"
                    class="btn-premium w-full py-4 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm hover:shadow-luxury transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-98 border-t border-white/10">
                <span id="btnText">Send Reset Link</span>
                <span id="btnSpinner" class="hidden"><i class="fa-solid fa-spinner animate-spin"></i></span>
            </button>

            <a href="{{ route('login') }}" 
               class="w-full py-3.5 rounded-2xl border border-coffee-100 dark:border-gray-800 text-coffee-600 dark:text-gray-300 font-bold text-xs flex items-center justify-center gap-2 transition-all hover:bg-coffee-50/40 active:scale-98">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Sign In
            </a>
        </div>
    </form>

    <script>
        function handleForgotPasswordSubmit(btn, e) {
            const form = document.getElementById('forgotPasswordForm');
            if(form.checkValidity()) {
                document.getElementById('btnText').textContent = 'Sending Link...';
                document.getElementById('btnSpinner').classList.remove('hidden');
                btn.disabled = true;
                form.submit();
            }
        }
    </script>
</x-guest-layout>
