@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-neutral-dark">
        <a 
            href="{{ route('social.posts.show', $post->id) }}" 
            class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary"
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

            removeTemporaryImage(index) {
                this.$wire.call('removeTemporaryImage', index);
            },

        }"
        x-on:media-manager:file-selected.window="setImage"
        x-on:update-post:image-set.window="setImages"
        class="w-full"
    >
        <div class="col-span-4 card">
            <div class="p-6 space-y-4">
                <div>
                    <x-library::tiptap 
                        wire:model.defer="post.body"
                        heightClass="m-1 text-lg"
                        wordCountType="character"
                        characterLimit="500"
                        class="bg-secondary text-lg"
                    >
                        <x-slot name="footer">
                            <div class="bg-secondary">
                                <ul
                                    x-show="showImages"
                                    x-transition
                                    role="list"
                                    class="px-4 grid grid-cols-4 gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8"
                                >
                                    <template x-for="(image, index) in images" :key="index">
                                        <li class="col-span-1 relative cursor-pointer">
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
                            <x-library::input.error for="post.body" class="mt-2"/>
                        </div>
                    </div>
                </div>
                <div>
                    @if ($postMedia?->count())
                        <div>
                            Post images:
                        </div>
                        <div class="flex flex-wrap w-full space-x-4">
                            @foreach ($postMedia as $key => $media)
                                <div class="w-56 relative">
                                    <div 
                                        wire:loading 
                                        wire:target="removeImage, setFeaturedImage" 
                                        class="absolute z-10 rounded-lg w-full h-full flex justify-center items-center bg-gray-500/75"
                                    >
                                        <x-heroicon-o-refresh class="animate-spin w-8 h-8 absolute top-1/2 right-1/2 -mr-4 -mt-4" role="status" />
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="relative">
                                        <button
                                            wire:click.prevent="confirmMediaRemoval({{ $media->id }})"
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
    <!-- Remove Media Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingMediaRemoval">
        <x-slot name="title">
            {{ \Trans::get('Remove Media') }}
        </x-slot>

        <x-slot name="content">
            {{ \Trans::get('Are you sure you would like to remove this image? This cannot be undone.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingMediaRemoval')" wire:loading.attr="disabled">
                {{ \Trans::get('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeImage" wire:loading.attr="disabled">
                {{ \Trans::get('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
@endsection
