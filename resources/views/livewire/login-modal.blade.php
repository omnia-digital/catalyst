<x-library::modal id="login-modal">
    <x-slot:title>Login</x-slot:title>
    <x-slot:content>
        <div>
            <x-library::input.text label="Email" wire:model.defer="email" type="email"/>
            <x-library::input.error for="email"/>
        </div>

        <div class="mt-6">
            <x-library::input.text label="Password" wire:model.defer="password" type="password"/>
            <x-library::input.error for="password"/>
        </div>

        <div class="mt-6">
            <label for="remember_me" class="flex items-center">
                <x-jet-checkbox id="remember_me" wire:model.defer="remember"/>
                <span class="ml-2 text-sm text-base-text-color">{{ \Trans::get('Remember me') }}</span>
            </label>
        </div>
    </x-slot:content>
    <x-slot:actions>
        <x-library::button wire:click.prevent="login">Login</x-library::button>
    </x-slot:actions>
</x-library::modal>
