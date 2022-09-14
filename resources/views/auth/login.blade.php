<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ config('app.logo_path') }}" class="h-24"/>
        </x-slot>

        <x-slot name="slogan">
            <x-library::heading.1 text-color="text-heading-default-color">{{Trans::get('Come for the games. Stay for the community.')}}</x-library::heading.1>
            <x-library::heading.3 class="text-center">{{Trans::get('Login to Hatchet')}}</x-library::heading.3>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ \Trans::get('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ \Trans::get('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-base-text-color">{{ \Trans::get('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-base-text-color hover:text-dark-text-color" href="{{ route('password.request') }}">
                        {{ \Trans::get('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ \Trans::get('Log in') }}
                </x-jet-button>
            </div>
        </form>

        <x-slot name="additionalCard">
            <div class="flex items-center justify-center">
                <p class="text-sm text-base-text-color">
                    Don't have an account?&nbsp;
                    <a class="underline text-sm text-base-text-color hover:text-dark-text-color" href="{{ route('register') }}">
                        {{ \Trans::get('Sign Up') }}
                    </a>
                </p>
            </div>
        </x-slot>
    </x-jet-authentication-card>
</x-guest-layout>
