<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ Trans::get('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ Trans::get('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ Trans::get('Current Password') }}"/>
            <x-input id="current_password" type="password" class="mt-1 block w-full"
                     wire:model.live="state.current_password" autocomplete="current-password"/>
            <x-input-error for="current_password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ Trans::get('New Password') }}"/>
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model.live="state.password"
                     autocomplete="new-password"/>
            <x-input-error for="password" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ Trans::get('Confirm Password') }}"/>
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                     wire:model.live="state.password_confirmation" autocomplete="new-password"/>
            <x-input-error for="password_confirmation" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ Trans::get('Saved.') }}
        </x-action-message>

        <x-button>
            {{ Trans::get('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
