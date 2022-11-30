<x-library::modal id="authentication-modal">
    <x-slot:title>{{ $showLoginModal ? 'Login' : 'Register' }}</x-slot:title>
    <x-slot:content>
        <div>
            @if(!$showLoginModal)
                <div class="mt-6">
                    <x-library::input.text label="First Name" wire:model.defer="firstName"/>
                    <x-library::input.error for="firstName"/>
                </div>
            @endif
        </div>

        <div>
            @if(!$showLoginModal)
                <div class="mt-6 mb-6">
                    <x-library::input.text label="Last Name" wire:model.defer="lastName"/>
                    <x-library::input.error for="lastName"/>
                </div>
            @endif
        </div>

        <div>
            <x-library::input.text label="Email" wire:model.defer="email" type="email"/>
            <x-library::input.error for="email"/>
        </div>

        <div class="mt-6">
            <x-library::input.text label="Password" wire:model.defer="password" type="password"/>
            <x-library::input.error for="password"/>
        </div>

        <div>
            @if (!$showLoginModal)
                <div class="mt-6">
                    <x-library::input.text label="{{ \Trans::get('Confirm Password') }}" wire:model.defer="password_confirmation" type="password"/>
                    <x-library::input.error for="password_confirmation"/>
                </div>
            @endif
        </div>

        <div>
            @if($showLoginModal)
                <div class="mt-6">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" wire:model.defer="remember"/>
                        <span class="ml-2 text-sm text-base-text-color">{{ \Trans::get('Remember me') }}</span>
                    </label>
                </div>
            @endif
        </div>

        <div class="mt-4">
            @if (!$showLoginModal)
                <a href="#" class="hover:text-primary hover:underline" wire:click.prevent="showLoginModal">Have an account?</a>
            @else
                <a href="#" class="hover:text-primary hover:underline" wire:click.prevent="showRegisterModal">Sign up</a>
            @endif
        </div>
    </x-slot:content>
    <x-slot:actions>
        <x-library::button wire:click.prevent="{{ $showLoginModal ? 'login' : 'register' }}">
            {{ $showLoginModal ? 'Login' : 'Register' }}
        </x-library::button>
    </x-slot:actions>
</x-library::modal>
