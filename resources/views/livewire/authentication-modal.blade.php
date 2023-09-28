<x-library::modal id="authentication-modal" hideCancelButton="true">
    @if ($showLoginModal)
        <x-slot:title>Login</x-slot:title>
        <x-slot:content>
            <div>
                <x-library::input.text label="Email" wire:model.live="email" type="email"/>
                <x-library::input.error for="email"/>
            </div>

            <div class="mt-6">
                <x-library::input.text label="Password" wire:model.live="password" type="password"/>
                <x-library::input.error for="password"/>
            </div>
            <div>
                <div class="mt-6">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" wire:model.live="remember"/>
                        <span class="ml-2 text-sm text-base-text-color">{{ \Trans::get('Remember me') }}</span>
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <a href="#" class="text-primary hover:underline" wire:click.prevent="showRegisterModal">Sign up</a>
            </div>
        </x-slot:content>
        <x-slot:actions>
            <x-library::button class="w-full px-4 py-2 font-semibold text-lg text-white-text-color uppercase hover:bg-primary-200" wire:click.prevent="login">Login</x-library::button>
        </x-slot:actions>
    @else
        <x-slot:title>Register</x-slot:title>
        <x-slot:content>
            @if (\Modules\Forms\Models\Form::getRegistrationForm())
                <livewire:forms::user-registration-form
                    :form="\Modules\Forms\Models\Form::getRegistrationForm()"
                    submitText="Sign Up"
                />
            @else
                <x-forms.register-default-form/>
            @endif
            <div class="mt-4">
                <a href="#" class="text-primary hover:underline" wire:click.prevent="showLoginModal">Have an account?</a>
            </div>
        </x-slot:content>
    @endif
</x-library::modal>
