<div>
    <x-library::modal id="add-resource-modal" maxWidth="5xl">
        <x-slot name="title">Add Resource</x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-library::input.text label="Title" wire:model="title"/>
                <x-library::input.error for="title"/>
            </div>
            <div class="mt-6">
                <x-library::input.text label="URL" wire:model="url"/>
                <x-library::input.error for="url"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Body"/>
                <p class="my-4 italic text-primary">You can even use Markdown to style and format your Resource! Not
                    sure how to use it? Here's the official guide: <a href="https://www.markdownguide.org/basic-syntax/"
                                                                      class="underline hover:no-underline">https://www.markdownguide.org/basic-syntax/</a>
                </p>
                <x-library::tiptap wire:model="body"/>
                <x-library::input.error for="body"/>
                <x-library::input.help value="Maximum is 2500 characters"/>
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
            <x-library::button wire:click="addResource">Add Resource</x-library::button>

            {{--            <livewire:social::post-editor :title :wire:key="uniqid()" submit-text="Add Resource"/>--}}
        </x-slot>
    </x-library::modal>

    <livewire:media-manager/>
</div>
