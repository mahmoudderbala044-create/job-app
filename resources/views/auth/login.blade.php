<x-guest-layout>
    <h2 class="text-2xl font-bold text-center text-white mb-6">{{ __('Login to your account') }}</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-zinc-900 border-white/10 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-zinc-900" name="remember">
                <span class="ms-2 text-sm text-zinc-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-zinc-400 hover:text-zinc-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center border-t border-white/10 pt-4">
            <p class="text-sm text-zinc-400">
                {{ __("Don't have an account?") }}
                <a class="underline text-indigo-400 hover:text-indigo-300 font-semibold rounded-md focus:outline-none" href="{{ route('register') }}">
                    {{ __('Create one here') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
