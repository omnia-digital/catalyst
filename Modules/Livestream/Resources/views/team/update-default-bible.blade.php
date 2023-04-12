<x-jet-form-section submit="updateDefaultBible">
    <x-slot name="title">
        {{ __('Update Default Bible') }}
    </x-slot>

    <x-slot name="description">
{{--        {{ __('We will use this timezone setting for all your livestreams, episodes, etc.') }}--}}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-input.label value="Default Bible"/>
            <x-input.select id="default-bible" wire:model.defer="defaultBible" :options="$bibleOptions" enableDefaultOption :default="null" placeholder="None"/>
            <x-jet-input-error for="defaultBible" class="mt-2" />
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
