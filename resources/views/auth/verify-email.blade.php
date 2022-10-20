<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ config('app.logo_path') }}" class="h-16"/>
        </x-slot>

        <x-slot name="slogan">
            <x-library::heading.2 text-color="text-heading-default-color" class="mt-6">{{Trans::get(config('app.slogan', ''))}}</x-library::heading.2>
        </x-slot>

        <x-library::heading.2 class="text-center mb-2">{{ Trans::get("Let's make it official. Please verify your email") }}</x-library::heading.2>

        @if (session("status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="mb-4 text-sm text-base-text-color">
            {{ \Trans::get('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ \Trans::get('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ \Trans::get('Resend Verification Email') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-base-text-color hover:text-dark-text-color">
                    {{ \Trans::get('Log Out') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
