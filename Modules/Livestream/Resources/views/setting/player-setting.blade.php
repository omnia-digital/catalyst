<x-form.section submit="updatePlayerSetting">
    <x-slot name="form">
        <div class="col-span-6">
            <x-input.label value="Not Live Image"/>
            <x-input.filepond id="not-live-image" wire:model="notLiveImage" :defaultImage="$currentNotLiveImage"/>
            <x-input-error for="notLiveImage" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-input.label value="Before Live Image"/>
            <x-input.filepond id="before-live-image" wire:model="beforeLiveImage"
                              :defaultImage="$currentBeforeLiveImage"/>
            <x-input-error for="beforeLiveImage" class="mt-2"/>
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
</x-form.section>
