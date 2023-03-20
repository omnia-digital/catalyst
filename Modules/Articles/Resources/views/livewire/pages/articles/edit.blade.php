@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mr-4">
        <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
            <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary">
                <a href="{{ route('articles.show', $article->id) }}">
                    Cancel
                </a>
            </div>
            <a href="{{route('articles.home')}}">
                <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Edit Article') }}</x-library::heading.1>
            </a>
        </div>
        <div class="w-full">
            <div class="col-span-4 card">
                <div class="p-6">
                    <div class="mt-4">
                        <x-library::input.label value="Title"/>
                        <x-library::input.text class="!bg-white border-gray-600" wire:model.defer="article.title"/>
                        <x-library::input.error for="article.title"/>
                    </div>
                    <div class="mt-6">
                        <x-library::input.label value="URL"/>
                        <x-library::input.text class="!bg-white border-gray-600" wire:model.defer="article.url"/>
                        <x-library::input.error for="article.url"/>
                    </div>
                    <div class="mt-4">
                        <x-library::input.label value="Body"/>
                        <p class="my-4 italic text-primary">You can even use Markdown to style and format your Article! Not sure how to use it? Here's the official guide: <a
                                    href="https://www.markdownguide.org/basic-syntax/" class="underline hover:no-underline">https://www.markdownguide.org/basic-syntax/</a></p>
                        <x-library::tiptap wire:model.defer="article.body"/>
                        <x-library::input.error for="article.body"/>
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
                                <x-heroicon-o-refresh class="animate-spin w-8 h-8 absolute top-1/2 right-1/2 -mr-4 -mt-4" role="status"/>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <x-library::input.media-manager
                                    id="article-featured-image"
                                    setImageAction="setFeaturedImage"
                                    removeImageAction="removeFeaturedImage"
                                    :file="$this->article->image ?? null"
                                    label="Add Image (Upload, Unsplash, URL)"
                            />
                        </div>
                        <x-library::input.error for="image"/>
                    </div>
                    <div class="flex justify-end mt-8 space-x-2">
                        <x-library::button.secondary wire:click="saveAsDraft">Save as Draft</x-library::button.secondary>
                        <x-library::button wire:click="publishArticle">Publish</x-library::button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:media-manager/>
@endsection
