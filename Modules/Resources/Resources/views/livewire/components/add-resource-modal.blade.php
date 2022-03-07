<div>
    <x-library::modal id="add-resource-modal">
        <x-slot name="title">Add Resource</x-slot>
        <x-slot name="content">
            <div>
                <x-library::input.text label="Title" wire:model.defer="title"/>
                <x-library::input.error for="title"/>
            </div>
            <div class="mt-6">
                <x-library::input.text label="URL" wire:model.defer="url"/>
                <x-library::input.error for="url"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Body"/>
                <x-library::input.textarea wire:model.defer="body" placeholder="Body"/>
                <x-library::input.error for="body"/>
                <x-library::input.help value="Maximum is 500 characters"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Image"/>
                <x-library::input.media-manager
                        id="resource-featured-image"
                        setImageAction="setFeaturedImage"
                        removeImageAction="removeFeaturedImage"
                        :file="$image ?? null"
                />
                <x-library::input.error for="image"/>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-library::button wire:click="addResource">Add Resource</x-library::button>
        </x-slot>
    </x-library::modal>

{{--    @livewire('media-manager')--}}
</div>