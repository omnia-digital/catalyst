<div
    x-data="{
        showImages: false,

        images: [],

        setShowImages() {
            if (this.showImages) {
                this.showImages = false;
                return;
            }

            this.showImages = true;
            this.showMediaManager(null, {});
        },

        showMediaManager(file, metadata) {
            this.$wire.emitTo(
                'media-manager',
                'media-manager:show',
                {
                    id: 'post-editor',
                    file: file,
                    metadata: metadata
                }
            );
        },

        setImage(event) {
            if (event.detail.id === 'post-editor') {
                this.$wire.call('setImage', event.detail);
            }
        },

        setImages(event) {
            this.images = event.detail
        },

        removeImage(index) {
            this.$wire.call('removeImage', index);
        }
    }"
    x-on:media-manager:file-selected.window="setImage"
    x-on:post-editor:image-set.window="setImages"
>
    <x-library::tiptap
            wire:model.defer="content"
            heightClass="min-h-[80px]"
            wordCountType="character"
            characterLimit="500"
            placeholder="What\\'s happening?"
    >
        <x-slot name="footer">
            <div class="pb-4">
                <ul x-show="showImages" x-transition role="list" class="p-4 grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-6 xl:gap-x-8">
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

                    <li class="relative">
                        <button
                                x-on:click.prevent="showMediaManager(null, {})"
                                type="button"
                                class="relative block w-full h-full border-2 border-gray-300 border-dashed rounded-lg p-8 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        >
                            <x-coolicon-plus class="mx-auto h-8 w-8 text-gray-400"/>
                        </button>
                    </li>
                </ul>

                <div class="flex items-center space-x-2 px-4">
                    <button x-on:click.prevent.stop="setShowImages" type="button">
                        <x-heroicon-o-paper-clip class="w-5 h-5 text-gray-500"/>
                    </button>
                </div>
            </div>
        </x-slot>
    </x-library::tiptap>

    <div class="flex justify-between">
        <div>
            <x-library::input.error for="content" class="mt-2"/>
        </div>

        <div class="flex justify-end my-2">
            <x-library::button wire:click="submit" wire:target="submit">
                Post
            </x-library::button>
        </div>
    </div>

    @livewire('media-manager', ['handleUploadProcess' => false])
</div>