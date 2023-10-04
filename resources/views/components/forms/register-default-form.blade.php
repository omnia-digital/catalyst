<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <x-label for="first_name" value="{{ \OmniaDigital\CatalystCore\Facades\Translate::get('First Name') }}"/>
        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
                 required autofocus autocomplete="first_name"/>
    </div>

    <div class="mt-4">
        <x-label for="last_name" value="{{ \OmniaDigital\CatalystCore\Facades\Translate::get('Last Name') }}"/>
        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                 required autofocus autocomplete="last_name"/>
    </div>

    <div class="mt-4">
        <x-label for="email" value="{{ \OmniaDigital\CatalystCore\Facades\Translate::get('Email') }}"/>
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
    </div>

    <div class="mt-4">
        <x-label for="password" value="{{ \OmniaDigital\CatalystCore\Facades\Translate::get('Password') }}"/>
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                 autocomplete="new-password"/>
    </div>

    <div class="mt-4">
        <x-label for="password_confirmation" value="{{ \OmniaDigital\CatalystCore\Facades\Translate::get('Confirm Password') }}"/>
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                 required autocomplete="new-password"/>
    </div>

    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mt-4">
            <x-label for="terms">
                <div class="flex items-center">
                    <x-checkbox name="terms" id="terms"/>

                    <div class="ml-2">
                        {!! Translate::get('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-base-text-color hover:text-dark-text-color">'.\OmniaDigital\CatalystCore\Facades\Translate::get('Trans of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-base-text-color hover:text-dark-text-color">'.\OmniaDigital\CatalystCore\Facades\Translate::get('Privacy Policy').'</a>',
                        ]) !!}
                    </div>
                </div>
            </x-label>
        </div>
    @endif

    <div class="flex items-center justify-end mt-4">
        <x-button class="w-full py-2 text-lg justify-center">
            {{ \OmniaDigital\CatalystCore\Facades\Translate::get('Sign Up') }}
        </x-button>
    </div>
</form>
