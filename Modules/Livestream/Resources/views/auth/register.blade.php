<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo/>
        </x-slot>

        @if (!request('social-provider'))
            @include('auth.social-login', ['text' => 'Sign up with Facebook'])
        @endif

        <div class="mt-2 mb-4 grid grid-cols-1 gap-3">
            <div>
                <a href="{{ route('login') }}"
                   class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <x-heroicon-o-login class="w-5 h-5"/>
                    <span class="ml-2">Login with your email</span>
                </a>
            </div>
        </div>

        <x-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if (request('social-provider'))
                <x-alert.info>We've pulled in your {{ Str::title(request('social-provider')) }} info. Please complete
                    the remaining fields.
                </x-alert.info>
            @endif

            <div class="mt-4">
                <x-label for="first_name" value="{{ __('First Name') }}"/>
                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                         :value="old('first_name') ?? request('first_name')" required autofocus
                         autocomplete="first_name"/>
            </div>

            <div class="mt-4">
                <x-label for="last_name" value="{{ __('Last Name') }}"/>
                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                         :value="old('last_name') ?? request('last_name')" required autofocus autocomplete="last_name"/>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}"/>
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}"/>
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                         autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                         name="password_confirmation" required autocomplete="new-password"/>
            </div>

            <input type="hidden" name="provider_user_id" value="{{ request('provider_user_id') }}"/>
            <input type="hidden" name="provider" value="{{ request('social-provider') }}"/>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
