<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#1c002f] to-[#0a0f2b] p-4 font-sans">
        {{-- Frosted glass panel with rounded corners --}}
        <div class="w-full max-w-sm rounded-3xl p-6 relative z-10 backdrop-blur-xl bg-white/5 shadow-2xl border border-white/10 transform transition-all duration-300 hover:scale-[1.01]">
            <div class="mb-6 text-center">
                <img src="{{ asset('images/Logo Semar Arena.jpeg') }}" 
                     alt="Logo" 
                     class="h-16 w-16 mx-auto rounded-full ring-4 ring-white/20 shadow-lg mb-2 transform transition-transform duration-300 hover:scale-110">
                <h1 class="text-xl font-bold text-white tracking-wide">Forgot Password?</h1>
                <p class="text-xs text-slate-300">No problem. Just enter your email.</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4 text-green-400" :status="session('status')" />

            <div class="mb-4 text-sm text-slate-400">
                {{ __('Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email Address --}}
                <div class="space-y-4">
                    <x-input-label for="email" :value="__('Email')" class="text-xs font-medium text-slate-300"/>
                    <x-text-input id="email" 
                                  class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-2 text-white placeholder-slate-500 focus:bg-white/10 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-400/25 transition duration-200" 
                                  type="email" 
                                  name="email" 
                                  :value="old('email')" 
                                  required 
                                  autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-indigo-600 to-purple-700 px-4 py-3 font-semibold text-white shadow-lg hover:from-indigo-700 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/50 transition transform hover:scale-[1.01] active:scale-95 duration-200">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>