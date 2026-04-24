<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#1c002f] to-[#0a0f2b] p-4 font-sans">
        {{-- Frosted glass panel with rounded corners --}}
        <div class="w-full max-w-sm rounded-3xl p-5 relative z-10 backdrop-blur-xl bg-white/5 shadow-2xl border border-white/10 transform transition-all duration-300 hover:scale-[1.01]">
            <div class="mb-5 text-center">
                <img src="{{ asset('images/Logo Semar Arena.jpeg') }}" 
                     alt="Logo" 
                     class="h-16 w-16 mx-auto rounded-full ring-4 ring-white/20 shadow-lg mb-2 transform transition-transform duration-300 hover:scale-110">
                <h1 class="text-xl font-bold text-white tracking-wide">Create Account</h1>
                <p class="text-xs text-slate-300">Join us and discover new features!</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-xs font-medium text-slate-300"/>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                           placeholder="Your full name"
                           class="mt-1 w-full rounded-xl border border-white/20 bg-white/5 px-3 py-1.5 text-sm text-white placeholder-slate-500 focus:bg-white/10 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-400/25 transition duration-200"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-0.5" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-medium text-slate-300"/>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                           placeholder="you@example.com"
                           class="mt-1 w-full rounded-xl border border-white/20 bg-white/5 px-3 py-1.5 text-sm text-white placeholder-slate-500 focus:bg-white/10 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-400/25 transition duration-200"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-0.5" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-xs font-medium text-slate-300"/>
                    <div class="relative mt-1">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               placeholder="••••••••"
                               class="w-full rounded-xl border border-white/20 bg-white/5 px-3 py-1.5 pr-10 text-sm text-white placeholder-slate-500 focus:bg-white/10 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-400/25 transition duration-200"/>
                        <button type="button" onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-300 hover:text-white transition duration-200">
                            {{-- Icon Mata --}}
                            <svg id="eyeIcon-password" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-0.5" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-xs font-medium text-slate-300"/>
                    <div class="relative mt-1">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               placeholder="••••••••"
                               class="w-full rounded-xl border border-white/20 bg-white/5 px-3 py-1.5 pr-10 text-sm text-white placeholder-slate-500 focus:bg-white/10 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-400/25 transition duration-200"/>
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-300 hover:text-white transition duration-200">
                            {{-- Icon Mata --}}
                            <svg id="eyeIcon-password_confirmation" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-0.5" />
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-700 px-4 py-2 font-semibold text-white shadow-lg hover:from-indigo-700 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition transform hover:scale-[1.01] active:scale-95 duration-200">
                    REGISTER
                </button>

                <p class="text-center text-xs text-slate-400 mt-1">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-semibold text-indigo-400 hover:underline transition duration-200">Login here</a>
                </p>
            </form>
        </div>
    </div>

    {{-- Script to toggle password visibility --}}
    <script>
        const eyeOpenSVG = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
        const eyeClosedSVG = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.343-3.993m.361-1.396A9.95 9.95 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-2.343 3.993m-1.285 1.285L9.5 9.5m4.5 2.5l2.5-2.5m-7-7L7 7m5 5L7 7m-1 1l7 7m1 1l-7-7m1-1l-7 7m7-7l-7 7m7 7l-7-7m1-1l7 7m1 1l-7-7"></path>`;

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(`eyeIcon-${inputId}`);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.343-3.993M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = eyeOpenSVG;
            }
        }
    </script>
</x-guest-layout>