@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-neutral-dark">
        <a 
            href="{{ route('social.posts.show', $post->id) }}" 
            class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-primary hover:text-primary"
        >Cancel</a>
        <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Edit Post') }}</x-library::heading.1>
    </div>
    <div
        x-data="{
            openState: false,
            showImages: true,
            images: [],
            users: {},
            showMediaManager(file, metadata) {
                this.$wire.emitTo(
                    'media-manager',
                    'media-manager:show',
                    {
                        id: '{{ $editorId }}',
                        file: file,
                        metadata: metadata
                    }
                );
            },

            setImage(event) {
                if (event.detail.id === '{{ $editorId }}') {
                    this.$wire.call('setImage', event.detail);
                }
            },

            setImages(event) {
                if (event.detail.id === '{{ $editorId }}') {
                    this.images = event.detail.images
                }
            },

            removeImage(index) {
                this.$wire.call('removeImage', index);
            },

        }"
        x-on:media-manager:file-selected.window="setImage"
        x-on:upadate-post:image-set.window="setImages"
        class="w-full"
    >
        <div class="col-span-4 card">
            <div class="p-6 space-y-4">
                <div>
                    <x-library::tiptap 
                        wire:model.defer="content"
                        heightClass="m-1 text-lg"
                        wordCountType="character"
                        characterLimit="500"
                        class="bg-primary text-lg"
                    >
                        <x-slot name="footer">
                            <div class="bg-primary">
                                <ul
                                    x-show="showImages"
                                    x-transition
                                    role="list"
                                    class="px-4 grid gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8"
                                    x-bind:class="{'grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6': images.length > 2, 'grid-cols-1': images.length === 1, 'grid-cols-2': images.length === 2}"
                                >
                                    <template x-for="(image, index) in images" :key="index">
                                        <li class="relative cursor-pointer">
                                            <button
                                                x-on:click.prevent.stop="removeTemporaryImage(index)"
                                                type="button"
                                                class="absolute -top-2 -right-2 z-10 bg-red-100 rounded-full p-1 inline-flex items-center justify-center hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
                                            >
                                                <x-heroicon-o-x class="w-5 h-5 text-red-500 hover:text-red-400"/>
                                            </button>
            
                                            <div class="focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden">
                                                <img x-bind:src="image" alt="" class="group-hover:opacity-75 object-cover pointer-events-none">
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </x-slot>
                    </x-library::tiptap>
                    <hr class="text-neutral-light"/>
                    <div class="flex items-center pt-3 pb-2 space-x-4">
                        @if($openState == false)
                            <div class="flex items-center space-x-2 px-4">
                                <button 
                                    title="Add Image" 
                                    x-on:click.prevent.stop="showMediaManager(null, {})" 
                                    type="button"
                                    class="group"
                                >
                                    <i class="fa-solid fa-image w-5 h-5 text-gray-500 group-hover:text-gray-700"></i>
                                </button>
                            </div>
                        @endif
                        <div>
                            <x-library::input.error for="content" class="mt-2"/>
                        </div>
                    </div>
                </div>
                <div>
                    @if ($post->getMedia()->count())
                        <div>
                            Post images:
                        </div>
                        <div class="flex flex-wrap w-full space-x-4">
                            @foreach ($post->getMedia() as $key => $media)
                                <div class="w-56 relative">
                                    <div 
                                        wire:loading 
                                        wire:target="removeImage, setFeaturedImage" 
                                        class="absolute z-10 rounded-lg w-full h-full flex justify-center items-center bg-gray-500/75"
                                    >
                                        <x-heroicon-o-refresh class="animate-spin w-8 h-8 absolute top-1/2 right-1/2 -mr-4 -mt-4" role="status" />
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    {{-- <x-library::input.media-manager
                                        id="post-image-{{ $key }}"
                                        setImageAction="setFeaturedImage"
                                        removeImageAction="removeImage({{ $media->id }})"
                                        :file="$media->getFullUrl() ?? null"
                                        label="Add Image (Upload, Unsplash, URL)"
                                    /> --}}
                                    <div class="relative">
                                        <button
                                            wire:click.prevent="removeImage({{ $media->id }})"
                                            type="button"
                                            class="absolute -top-2 -right-2 z-10 bg-red-100 rounded-full p-1 inline-flex items-center justify-center hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
                                        >
                                            <x-heroicon-o-x class="w-5 h-5 text-red-500 hover:text-red-400"/>
                                        </button>
                                        <div
                                            x-on:click.prevent="showMediaManager('{{ $media->getFullUrl() }}', {})"
                                            class="block w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden cursor-pointer"
                                        >
                                            <img src="{{ $media->getFullUrl() }}" title="{{ $media->name }}" alt="{{ $media->name }}" class="object-cover">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="flex justify-end">
                    <x-library::button wire:click="updatePost">Update Post</x-library::button>
                </div>
            </div>
        </div>        
    </div>
    <livewire:media-manager/>
@endsection
