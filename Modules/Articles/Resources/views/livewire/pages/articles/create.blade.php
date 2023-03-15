<div>
    <x-library::modal id="add-article-modal" maxWidth="5xl">
        <x-slot name="title">Add Article</x-slot>
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
                <p class="my-4 italic text-primary">You can even use Markdown to style and format your Article! Not sure how to use it? Here's the official guide: <a href="https://www.markdownguide.org/basic-syntax/" class="underline hover:no-underline">https://www.markdownguide.org/basic-syntax/</a></p>
                <x-library::tiptap wire:model.defer="body"/>
                <x-library::input.error for="body"/>
                <x-library::input.help value="Maximum is 2500 characters"/>
            </div>
            <div class="mt-4">
                <x-library::input.label value="Image"/>
                <x-library::input.media-manager
                        id="article-featured-image"
                        setImageAction="setFeaturedImage"
                        removeImageAction="removeFeaturedImage"
                        :file="$image ?? null"
                        label="Add Image (Upload, Unsplash, URL)"
                />
                <x-library::input.error for="image"/>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-library::button wire:click="addArticle">Add Article</x-library::button>

            {{--            <livewire:social::post-editor :title :wire:key="uniqid()" submit-text="Add Article"/>--}}
        </x-slot>
    </x-library::modal>

    <livewire:media-manager/>
</div>
