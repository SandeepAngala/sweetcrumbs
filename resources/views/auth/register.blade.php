<x-guest-layout>
    <!-- Brand Header for Form -->
    <div class="mb-6 text-center md:text-left">
        <h2 class="font-display text-3xl font-black text-coffee-800 dark:text-white leading-tight">Create Account</h2>
        <p class="text-xs text-coffee-500 dark:text-gray-400 mt-1.5 font-medium">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-gold font-bold hover:underline transition-colors">Sign in here</a>
        </p>
    </div>

    <!-- Error Alerts (if any) -->
    @if ($errors->any())
        <div class="mb-5 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/20 text-rose-800 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50 text-xs font-semibold space-y-1">
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

    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
        @csrf

        <!-- Name Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-user text-xs"></i>
            </div>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   placeholder=" "
                   autocomplete="name"
                   class="w-full pl-11 pr-4 py-3 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="name" 
                   class="absolute left-11 top-3 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Full Name
            </label>
        </div>

        <!-- Email Address Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-envelope text-xs"></i>
            </div>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   placeholder=" "
                   autocomplete="username"
                   class="w-full pl-11 pr-4 py-3 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="email" 
                   class="absolute left-11 top-3 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Email Address
            </label>
        </div>

        <!-- Phone Number Input -->
        <div class="relative input-group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-coffee-400 dark:text-gray-500 transition-colors">
                <i class="fa-solid fa-phone text-xs"></i>
            </div>
            <input id="phone" 
                   type="tel" 
                   name="phone" 
                   value="{{ old('phone') }}" 
                   placeholder=" "
                   autocomplete="tel"
                   class="w-full pl-11 pr-4 py-3 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="phone" 
                   class="absolute left-11 top-3 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Phone Number (Optional)
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
                   oninput="checkPasswordStrength(this.value)"
                   class="w-full pl-11 pr-11 py-3 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="password" 
                   class="absolute left-11 top-3 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Password
            </label>
            <!-- Visibility toggler -->
            <button type="button" 
                    onclick="togglePasswordVisibility('password', this)"
                    class="absolute inset-y-0 right-4 flex items-center text-coffee-400 hover:text-gold dark:text-gray-500 dark:hover:text-gold transition-colors">
                <i class="fa-solid fa-eye text-xs"></i>
            </button>
        </div>

        <!-- Password Strength Meter -->
        <div class="space-y-1">
            <div class="h-1 w-full bg-coffee-100 dark:bg-gray-800 rounded-full overflow-hidden">
                <div id="strengthBar" class="h-full w-0 bg-rose-500 transition-all duration-300"></div>
            </div>
            <div class="flex justify-between items-center text-[10px] text-coffee-400 dark:text-gray-500 font-bold uppercase tracking-wider">
                <span>Strength</span>
                <span id="strengthText">Too Short</span>
            </div>
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
                   class="w-full pl-11 pr-11 py-3 rounded-2xl bg-coffee-50/50 dark:bg-gray-950/40 border border-coffee-100 dark:border-gray-800/80 text-coffee-950 dark:text-white text-xs font-semibold focus:border-gold focus:ring-2 focus:ring-gold/20 focus:bg-white dark:focus:bg-gray-950 transition-all placeholder-transparent outline-none" />
            <label for="password_confirmation" 
                   class="absolute left-11 top-3 text-xs text-coffee-400 dark:text-gray-500 transition-all pointer-events-none select-none font-semibold">
                Confirm Password
            </label>
            <!-- Visibility toggler -->
            <button type="button" 
                    onclick="togglePasswordVisibility('password_confirmation', this)"
                    class="absolute inset-y-0 right-4 flex items-center text-coffee-400 hover:text-gold dark:text-gray-500 dark:hover:text-gold transition-colors">
                <i class="fa-solid fa-eye text-xs"></i>
            </button>
        </div>

        <!-- Terms and Conditions Checkbox -->
        <div class="flex items-start text-xs pt-1">
            <label for="terms" class="inline-flex items-start cursor-pointer select-none font-semibold text-coffee-500 dark:text-gray-400">
                <input id="terms" 
                       type="checkbox" 
                       required
                       class="rounded-lg border-coffee-200 dark:border-gray-800 bg-coffee-50/50 dark:bg-gray-950/40 text-gold focus:ring-gold/45 w-4.5 h-4.5 mt-0.5 transition-colors cursor-pointer" />
                <span class="ms-2.5 leading-normal">
                    I agree to the <a href="#" onclick="event.preventDefault(); showToast('Terms of Service coming soon!', 'info')" class="text-gold hover:underline font-bold">Terms of Service</a> & <a href="#" onclick="event.preventDefault(); showToast('Privacy Policy coming soon!', 'info')" class="text-gold hover:underline font-bold">Privacy Policy</a>
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                onclick="handleRegisterSubmit(this, event)"
                class="btn-premium w-full py-3.5 bg-coffee-800 hover:bg-coffee-900 text-white font-bold rounded-2xl text-xs shadow-warm hover:shadow-luxury transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 active:scale-98 border-t border-white/10">
            <span id="btnText">Create Account</span>
            <span id="btnSpinner" class="hidden"><i class="fa-solid fa-spinner animate-spin"></i></span>
        </button>

        <!-- Social Separator -->
        <div class="relative flex items-center justify-center my-5">
            <div class="absolute inset-x-0 h-px bg-coffee-100 dark:bg-gray-800"></div>
            <span class="relative px-3 bg-[#FDFBF7] dark:bg-gray-900 text-[10px] uppercase tracking-wider font-extrabold text-coffee-400 dark:text-gray-500 transition-colors">Or register with</span>
        </div>

        <!-- Google OAuth Option -->
        <a href="{{ route('auth.google.redirect') }}" 
           id="google-register-btn"
           class="social-btn w-full py-2.5 px-4 rounded-2xl bg-white dark:bg-gray-900 hover:bg-coffee-50/40 border border-coffee-100 dark:border-gray-800 text-coffee-800 dark:text-gray-300 font-bold text-xs flex items-center justify-center gap-2.5 transition-all">
            <svg class="w-4 h-4" viewBox="0 0 24 24">
                <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.54 14.98 1 12 1 7.35 1 3.37 3.68 1.42 7.61l3.86 3C6.2 7.72 8.87 5.04 12 5.04z"/>
                <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.36H12v4.51h6.44c-.28 1.48-1.12 2.73-2.38 3.58l3.69 2.87c2.16-1.99 3.4-4.91 3.4-8.6z"/>
                <path fill="#FBBC05" d="M5.28 14.61c-.24-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29L1.42 7.03C.51 8.86 0 10.87 0 13s.51 4.14 1.42 5.97l3.86-3.36z"/>
                <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.69-2.87c-1.02.68-2.33 1.09-3.96 1.09-3.13 0-5.8-2.68-6.72-5.57l-3.86 3C3.37 20.32 7.35 23 12 23z"/>
            </svg>
            Continue with Google
        </a>

    </form>

    <!-- Client-side Scripts -->
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

        function checkPasswordStrength(password) {
            const bar = document.getElementById('strengthBar');
            const txt = document.getElementById('strengthText');
            
            if (password.length === 0) {
                bar.style.width = '0%';
                txt.textContent = 'Too Short';
                bar.className = 'h-full bg-rose-500';
                return;
            }

            let score = 0;
            if (password.length >= 8) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;

            if (password.length < 6) {
                bar.style.width = '20%';
                txt.textContent = 'Weak';
                bar.className = 'h-full bg-rose-500';
            } else if (score <= 1) {
                bar.style.width = '40%';
                txt.textContent = 'Fair';
                bar.className = 'h-full bg-orange-400';
            } else if (score === 2) {
                bar.style.width = '70%';
                txt.textContent = 'Medium';
                bar.className = 'h-full bg-amber-500';
            } else {
                bar.style.width = '100%';
                txt.textContent = 'Strong';
                bar.className = 'h-full bg-emerald-500';
            }
        }

        function handleRegisterSubmit(btn, e) {
            const form = document.getElementById('registerForm');
            if(form.checkValidity()) {
                document.getElementById('btnText').textContent = 'Creating Account...';
                document.getElementById('btnSpinner').classList.remove('hidden');
                btn.disabled = true;
                form.submit();
            }
        }
    </script>
</x-guest-layout>
