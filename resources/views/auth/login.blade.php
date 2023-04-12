<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ config('app.logo_path') }}" class="h-16"/>
        </x-slot>

        <x-slot name="slogan">
            <x-library::heading.2 text-color="text-heading-default-color" class="mt-6">{{ Trans::get(config('app.slogan', '')) }}</x-library::heading.2>
        </x-slot>

        <x-library::heading.2 class="text-center">{{ Trans::get('Login to') . ' ' . config('app.name') }}</x-library::heading.2>

        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ \Trans::get('Email') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ \Trans::get('Password') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember"/>
                    <span class="ml-2 text-sm text-base-text-color">{{ \Trans::get('Remember me') }}</span>
                </label>
            </div>

            <div class="text-center">
                <div class="flex items-center text-center justify-end mt-4 mb-2">
                    <x-jet-button class="w-full py-2 text-lg justify-center">
                        {{ \Trans::get('Log In') }}
                    </x-jet-button>
                </div>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-base-text-color hover:text-dark-text-color" href="{{ route('password.request') }}">
                        {{ \Trans::get('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>

        <x-slot name="additionalCard">
            <div class="flex items-center justify-center">
                <p class=" text-base-text-color">
                    {{ Trans::get("Don't have an account?") }}
                    <a class="underline text-lg font-bold text-base-text-color hover:text-dark-text-color" href="{{ route('register') }}">
                        {{ \Trans::get('Sign Up') }}
                    </a>
                </p>
            </div>
        </x-slot>
    </x-jet-authentication-card>
</x-guest-layout>
