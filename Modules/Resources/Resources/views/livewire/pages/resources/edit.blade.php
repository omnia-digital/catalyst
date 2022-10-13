<div>
    <x-library::modal id="edit-resource-modal" maxWidth="5xl">
        <x-slot name="title">Edit Resource</x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-library::input.text label="Title" wire:model.defer="title"/>
                <x-library::input.error for="title"/>
            </div>
            <div class="mt-6">
                <x-library::input.text label="URL" wire:model.defer="url"/>
                <x-library::input.error for="url"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Body"/>
                <x-library::tiptap wire:model.defer="body"/>
                <x-library::input.error for="body"/>
                <x-library::input.help value="Maximum is 2500 characters"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Resource Image" />
                <div class="mt-2">
                    @if ($resource?->image)
                        <div class="w-40 h-32 mr-2 mt-2 flex justify-center items-center bg-primary relative border-4 border-dashed border-neutral-dark">
                            <img src="{{ $resource?->image }}" title="{{ $resource?->title }}" alt="{{ $resource?->title }}" class="max-w-[152px] max-h-[120px]">
                            <button type="button" class="p-2 bg-neutral-dark/75 absolute top-0 right-0 hover:bg-neutral-dark" wire:click="confirmRemoval">
                                <x-heroicon-o-x class="w-6 h-6"/>
                            </button>
                        </div>
                    @else
                        <p>No image set.</p>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Image"/>
                <x-library::input.media-manager
                        id="resource-featured-image"
                        setImageAction="setFeaturedImage"
                        removeImageAction="removeFeaturedImage"
                        :file="$image ?? null"
                        label="Add Image (Upload, Unsplash, URL)"
                />
                <x-library::input.error for="image"/>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-library::button wire:click="updateResource">Update Resource</x-library::button>

            {{--            <livewire:social::post-editor :title :wire:key="uniqid()" submit-text="Add Resource"/>--}}
        </x-slot>
    </x-library::modal>

    <livewire:media-manager/>
</div>
