<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="{{ config('app.logo_path') }}" class="h-16"/>
        </x-slot>

        <x-slot name="slogan">
            <x-library::heading.2 text-color="text-heading-default-color " class="mt-6">{{Trans::get(config('app.slogan', ''))}}</x-library::heading.2>
        </x-slot>

        <x-library::heading.2 class="text-center">{{Trans::get('Create your account')}}</x-library::heading.2>

        <x-jet-validation-errors class="mb-4" />

        @if (\Modules\Forms\Models\Form::getRegistrationForm())
            <livewire:forms::form :form="\Modules\Forms\Models\Form::getRegistrationForm()"/>
        @else
            <x-forms.register-default-form/>
        @endif

        <x-slot name="additionalCard">
            <div class="flex items-center justify-center">
                <p class=" text-base-text-color">
                    {{ Trans::get('Already have an account?') }}
                    <a class="underline text-lg font-bold text-base-text-color hover:text-dark-text-color" href="{{ route('login') }}">
                        {{ \Trans::get('Log In') }}
                    </a>
                </p>
            </div>
        </x-slot>
    </x-jet-authentication-card>
</x-guest-layout>
