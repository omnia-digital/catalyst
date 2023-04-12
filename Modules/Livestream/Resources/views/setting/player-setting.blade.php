<x-form.section submit="updatePlayerSetting">
    <x-slot name="form">
        <div class="col-span-6">
            <x-input.label value="Not Live Image"/>
            <x-input.filepond id="not-live-image" wire:model.defer="notLiveImage" :defaultImage="$currentNotLiveImage"/>
            <x-jet-input-error for="notLiveImage" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-input.label value="Before Live Image"/>
            <x-input.filepond id="before-live-image" wire:model.defer="beforeLiveImage" :defaultImage="$currentBeforeLiveImage"/>
            <x-jet-input-error for="beforeLiveImage" class="mt-2"/>
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
</x-form.section>
