<x-form-section submit="updateDefaultBible">
    <x-slot name="title">
        {{ __('Update Default Bible') }}
    </x-slot>

    <x-slot name="description">
        {{--        {{ __('We will use this timezone setting for all your livestreams, episodes, etc.') }}--}}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-input.label value="Default Bible"/>
            <x-input.select id="default-bible" wire:model="defaultBible" :options="$bibleOptions"
                            enableDefaultOption :default="null" placeholder="None"/>
            <x-input-error for="defaultBible" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
