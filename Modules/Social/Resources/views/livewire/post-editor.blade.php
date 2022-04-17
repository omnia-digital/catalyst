<div
        x-data="{
        openState: false,
        showImages: true,
        images: [],

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
        }
    }"
        x-on:media-manager:file-selected.window="setImage"
        x-on:post-editor:image-set.window="setImages"
        class="bg-primary p-2 rounded-lg flex justify-start pt-4"
>
    <div class="mr-3 flex-shrink-0">
        <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->profile->name }}"/>
    </div>
    <div class="flex-1">
        @if($includeTitle)
            <div class="">
                <x-library::input.text label="Title" wire:model.defer="title"/>
                <x-library::input.error for="title"/>
            </div>
        @endif

        <x-library::tiptap
                wire:model.defer="content"
                heightClass="{{ $openState == false ?? 'min-h-[80px]'}} m-1 text-lg"
                wordCountType="character"
                characterLimit="500"
                :placeholder="$placeholder"
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
                                        x-on:click.prevent.stop="removeImage(index)"
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

                        {{--                    <li class="relative">--}}
                        {{--                        <button--}}
                        {{--                                x-on:click.prevent="showMediaManager(null, {})"--}}
                        {{--                                type="button"--}}
                        {{--                                class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-2 text-center hover:border-gray-400 focus:outline-none focus:ring-2--}}
                        {{--                                focus:ring-offset-2 focus:ring-gray-500"--}}
                        {{--                        >--}}
                        {{--                            <x-coolicon-plus class="mx-auto h-8 w-8 text-gray-400"/>--}}
                        {{--                        </button>--}}
                        {{--                    </li>--}}
                    </ul>
                </div>
            </x-slot>
        </x-library::tiptap>
        <hr class="text-neutral-light"/>
        <div class="flex justify-between items-center pt-1">
            @if($openState == false)
                <div class="flex items-center space-x-2 px-4">
                    <button x-on:click.prevent.stop="showMediaManager(null, {})" type="button">
                        <i class="fa-solid fa-image w-5 h-5 text-gray-500"></i>
                    </button>
                </div>
            @endif
            <div>
                <x-library::input.error for="content" class="mt-2"/>
            </div>

            <div class="flex justify-end my-2 mr-3">
                <x-library::button wire:click="submit" wire:target="submit" class="py-1 px-3 text-base">
                    {{ $submitButtonText }}
                </x-library::button>
            </div>
        </div>
    </div>
</div>
