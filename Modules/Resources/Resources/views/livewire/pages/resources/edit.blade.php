@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-secondary">
        <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-primary hover:text-primary">
            <a href="{{ route('resources.show', $resource->id) }}">
                Cancel
            </a>
        </div>
        <a href="{{route('resources.home')}}">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Edit Resource') }}</x-library::heading.1>
        </a>
    </div>
    <div class="w-full">
        <div class="col-span-4 card">
            <div class="p-6">
                <div class="mt-4">
                    <x-library::input.label value="Title" />
                    <x-library::input.text class="!bg-white border-gray-600" wire:model.defer="resource.title"/>
                    <x-library::input.error for="resource.title"/>
                </div>
                <div class="mt-6">
                    <x-library::input.label value="URL" />
                    <x-library::input.text class="!bg-white border-gray-600" wire:model.defer="resource.url"/>
                    <x-library::input.error for="resource.url"/>
                </div>
                <div class="mt-4">
                    <p class="my-4 text-neutral-dark">You can even use Markdown to style and format your Resource! Not sure how to use it? Here's the official guide: <a href="https://www.markdownguide.org/basic-syntax/" class="underline hover:no-underline">https://www.markdownguide.org/basic-syntax/</a></p>
                    <x-library::tiptap wire:model.defer="resource.body"/>
                    <x-library::input.error for="resource.body"/>
                    <x-library::input.help value="Maximum is 2500 characters"/>
                </div>
                <div class="mt-4">
                    <x-library::input.label value="Image"/>
                    <div class="w-56 relative">
                        <div 
                            wire:loading 
                            wire:target="removeFeaturedImage, setFeaturedImage" 
                            class="absolute z-10 rounded-lg w-full h-full flex justify-center items-center bg-gray-500/75"
                        >
                            <x-heroicon-o-refresh class="animate-spin w-8 h-8 absolute top-1/2 right-1/2 -mr-4 -mt-4" role="status" />
                            <span class="sr-only">Loading...</span>
                        </div>
                        <x-library::input.media-manager
                            id="resource-featured-image"
                            setImageAction="setFeaturedImage"
                            removeImageAction="removeFeaturedImage"
                            :file="$this->resource->image ?? null"
                            label="Add Image (Upload, Unsplash, URL)"
                        />
                    </div>
                    <x-library::input.error for="image"/>
                </div>
                <div class="flex justify-end mt-8">
                    <x-library::button wire:click="updateResource">Update Resource</x-library::button>
                </div>
            </div>
        </div>        
    </div>
    <livewire:media-manager/>
@endsection
