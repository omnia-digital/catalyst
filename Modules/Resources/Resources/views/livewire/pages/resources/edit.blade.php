@extends('catalyst::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mr-4">
        <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
            <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary">
                <a href="{{ route('resources.show', $resource->id) }}">
                    Cancel
                </a>
            </div>
            <a href="{{ route('resources.home') }}">
                <x-library::heading.1
                        class="py-4 hover:cursor-pointer">{{ Translate::get('Edit Resource') }}</x-library::heading.1>
            </a>
        </div>
        <div class="w-full">
            <div class="col-span-4 card">
                <div class="p-6">
                    <div class="mt-4">
                        <x-library::input.label value="Title"/>
                        <x-library::input.text class="!bg-white border-gray-600" wire:model="resource.title"/>
                        <x-library::input.error for="resource.title"/>
                    </div>
                    <div class="mt-6">
                        <x-library::input.label value="URL"/>
                        <x-library::input.text class="!bg-white border-gray-600" wire:model="resource.url"/>
                        <x-library::input.error for="resource.url"/>
                    </div>
                    {{-- // TODO: this is throwing an error in the JS console for some reason, need tp look into this.--}}
                    {{--                <div class="mt-6">--}}
                    {{--                    <div class="flex items-center">--}}
                    {{--                        <x-library::input.label value="{{ \Translate::get('What is your Team associated with?') }}" /><span class="text-red-600 text-sm ml-1">*</span>--}}
                    {{--                    </div>--}}
                    {{--                    <p class="text-neutral-dark">{{ \Translate::get('(you can choose more than one)') }}</p>--}}
                    {{--                    <x-library::input.selects wire:model.live="resourceTags" :options="$resourceTags"/>--}}
                    {{--                </div>--}}
                    @foreach ($resourceTags as $tag)
                        {{ $tag }}
                    @endforeach
                    <div class="mt-4">
                        <x-library::input.label value="Body"/>
                        <p class="my-4 italic text-primary">You can even use Markdown to style and format your Resource!
                            Not sure how to use it? Here's the official guide: <a
                                    href="https://www.markdownguide.org/basic-syntax/"
                                    class="underline hover:no-underline">https://www.markdownguide.org/basic-syntax/</a>
                        </p>
                        <x-library::tiptap wire:model="resource.body"/>
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
                                <x-library::icons.icon name="fa-light fa-arrows-rotate"
                                        class="animate-spin w-8 h-8 absolute top-1/2 right-1/2 -mr-4 -mt-4"
                                        role="status"/>
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
                    <div class="flex justify-end mt-8 space-x-2">
                        <x-library::button.secondary wire:click="saveAsDraft">Save as Draft
                        </x-library::button.secondary>
                        <x-library::button wire:click="publishResource">Publish</x-library::button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:media-manager/>
@endsection
