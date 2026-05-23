<x-guest-layout>
    <!-- Header -->
    <div class="mb-6 text-center md:text-left">
        <h2 class="font-display text-2xl font-black text-coffee-800 dark:text-white leading-tight">Verify Email</h2>
        <p class="text-xs text-coffee-500 dark:text-gray-400 mt-2 font-medium">
            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive it, we will gladly send you another.
        </p>
    </div>

    <!-- Status Alert -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50 text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500"></i> A new verification link has been sent to your email.
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
            @csrf
            <button type="submit" 
                    onclick="handleResendSubmit(this, event)"
                    class="btn-premium w-full py-4 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm hover:shadow-luxury transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-98 border-t border-white/10">
                <span id="btnText">Resend Verification Email</span>
                <span id="btnSpinner" class="hidden"><i class="fa-solid fa-spinner animate-spin"></i></span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-3.5 rounded-2xl border border-coffee-100 dark:border-gray-800 text-coffee-600 dark:text-gray-300 font-bold text-xs flex items-center justify-center gap-2 transition-all hover:bg-coffee-50/40 active:scale-98">
                <i class="fa-solid fa-right-from-bracket text-[10px]"></i> Log Out
            </button>
        </form>
    </div>

    <script>
        function handleResendSubmit(btn, e) {
            const form = document.getElementById('resendForm');
            document.getElementById('btnText').textContent = 'Sending...';
            document.getElementById('btnSpinner').classList.remove('hidden');
            btn.disabled = true;
            form.submit();
        }
    </script>
</x-guest-layout>
