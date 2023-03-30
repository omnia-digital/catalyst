<x-jet-form-section submit="updateTimezone">
    <x-slot name="title">
        {{ __('Update Timezone') }}
    </x-slot>

    <x-slot name="description">
        {{ __('We will use this timezone setting for all your livestreams, episodes, etc.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-input.label value="Timezone"/>
            <x-input.select id="timezone" wire:model.defer="timezone" :options="$timezones" enableDefaultOption :default="null" placeholder="Use from organization setting"/>
            <x-jet-input-error for="timezone" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
