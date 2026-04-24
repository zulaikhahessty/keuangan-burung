<x-guest-layout>
    {{-- ==== Split Login (Left form + Right logo panel) ==== --}}
    <div class="min-h-screen flex items-center justify-center px-4 py-10 bg-gradient-to-br from-[#e0e7ff] to-[#f3e8ff]">
        <div class="w-full max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-[2rem] bg-white shadow-2xl ring-1 ring-slate-200 overflow-hidden transform transition-transform duration-300 hover:scale-[1.01]">

                {{-- LEFT: Sign In form --}}
                <section class="order-2 lg:order-1 p-8 sm:p-10">
                    <div class="max-w-sm mx-auto">
                        <div class="mb-6">
                            <h1 class="text-3xl font-bold text-slate-900">Sign In</h1>
                            <p class="text-sm text-slate-600 mt-1">or use your email password</p>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700"/>
                                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                                       placeholder="you@example.com" autocomplete="username"
                                       class="mt-2 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 transition duration-200"/>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <div class="flex items-center justify-between">
                                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700"/>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition duration-200">Forget Your Password?</a>
                                    @endif
                                </div>

                                <div class="relative mt-2">
                                    <input id="password" type="password" name="password" required autocomplete="current-password"
                                           placeholder="••••••••"
                                           class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pr-12 text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/25 transition duration-200"/>
                                    {{-- Toggle eye button --}}
                                    <button type="button" onclick="togglePassword('password')" 
                                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 transition duration-200">
                                        <svg id="eyeIcon-password" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            {{-- Remember --}}
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember"
                                       class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="select-none">Remember me</span>
                            </label>

                            {{-- Submit --}}
                            <button type="submit"
                                    class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-700 px-4 py-3 font-semibold text-white shadow-lg hover:from-indigo-700 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition transform hover:scale-[1.01] active:scale-95 duration-200">
                                SIGN IN
                            </button>

                            {{-- Register link --}}
                            <p class="text-center text-sm text-slate-500">
                                Don’t have an account?
                                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline transition duration-200">Create one</a>
                            </p>
                        </form>
                    </div>
                </section>

                {{-- RIGHT: Dark gradient panel (Logo only, big & proportional) --}}
                <aside
                    class="order-1 lg:order-2 relative flex items-center justify-center p-10 text-center text-white">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0b163d] to-[#2d0e4f] lg:rounded-l-[6rem]"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <img src="{{ asset('images/Logo Semar Arena.jpeg') }}" 
                             alt="Logo" 
                             class="h-52 w-52 rounded-full ring-4 ring-white/30 shadow-2xl transition-transform duration-300 hover:scale-110">
                    </div>
                </aside>

            </div>

            <p class="mt-6 text-center text-xs text-slate-400">© {{ now()->year }} Semar Arena</p>
        </div>
    </div>

    {{-- Script toggle password --}}
    <script>
        const eyeOpenSVG = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
        const eyeClosedSVG = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.343-3.993m.361-1.396A9.95 9.95 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.343 3.993m-1.285 1.285L9.5 9.5m4.5 2.5l2.5-2.5m-7-7L7 7m5 5L7 7m-1 1l7 7m1 1l-7-7m1-1l-7 7m7-7l-7 7m7 7l-7-7m1-1l7 7m1 1l-7-7"></path>`;

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(`eyeIcon-${inputId}`);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = eyeClosedSVG;
            } else {
                input.type = 'password';
                icon.innerHTML = eyeOpenSVG;
            }
        }
    </script>
</x-guest-layout>