<div class="inline-flex items-center text-sm" x-data="{ repliesModalOpen: @entangle('modalOpen').defer }">
    <button
        type="button"
        class="inline-flex space-x-2 text-color-light hover:text-color-base"
        @click="repliesModalOpen = true"
    >
        <x-heroicon-o-chat-alt :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true" />
        <span class="font-medium text-color-dark">{{ $replyCount > 0 ? $replyCount : '' }}</span>
        <span class="sr-only">replies</span>
    </button>
    <div
      class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto"
      x-cloak
      x-show="repliesModalOpen"
      x-transition:enter="transition duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
        <div class="relative sm:w-3/4 md:w-1/2 mx-2 sm:mx-auto mt-10 mb-24 opacity-100">
            <div
            class="relative bg-primary shadow-lg rounded-lg text-color-dark z-20"
            x-cloak
            x-show="repliesModalOpen"
            @click.away="repliesModalOpen = false"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="scale-0"
            x-transition:enter-end="scale-100"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="scale-100"
            x-transition:leave-end="scale-0"
            >
                <header class="flex flex-row justify-between p-6 bg-primary border-b border-neutral-light rounded-t-lg">
                    <h2 class="font-semibold text-3xl text-color-dark">Comment</h2>
                    <button
                        class=""
                        @click="repliesModalOpen = false"
                    >
                        <x-heroicon-o-x class="w-6 h-6" />
                        <span class="sr-only">Close</span>
                    </button>
                </header>
                <footer class="flex justify-center bg-transparent border-t border-neutral-light">
                    <livewire:social::new-post-box :parentPostID="$post->id" :wire:key="'new-post-' . $post->id" class="my-6" />
                </footer>
            </div>
        </div>
    </div>
</div>
