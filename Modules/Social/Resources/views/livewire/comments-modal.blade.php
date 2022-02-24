<div class="inline-flex items-center text-sm" x-data="{ commentsModalOpen: false }">
    <button 
        type="button" 
        class="inline-flex space-x-2 text-gray-400 hover:text-gray-500"
        x-on:click="commentsModalOpen = true"
    >
        <x-heroicon-o-chat-alt class="h-5 w-5" aria-hidden="true" />
        <span class="font-medium text-gray-900">{{ $commentsCount }}</span>
        <span class="sr-only">replies</span>
    </button>
    <div
      class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto"
      x-show="commentsModalOpen"
      x-transition:enter="transition duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition duration-300"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
        <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto mt-10 mb-24 opacity-100">
            <div
            class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20"
            @click.away="commentsModalOpen = false"
            x-show="commentsModalOpen"
            x-transition:enter="transition transform duration-300"
            x-transition:enter-start="scale-0"
            x-transition:enter-end="scale-100"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="scale-100"
            x-transition:leave-end="scale-0"
            >
                <header class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-t-lg">
                    <h2 class="font-semibold text-3xl text-gray-800">Comments</h2>
                    <button
                        class=""
                        @click="commentsModalOpen = false"
                    >
                        <x-heroicon-o-x class="w-6 h-6" />
                        <span class="sr-only">Close</span>
                    </button>
                </header>
                <section class="p-3 text-center">
                    <ul class="space-y-4 divide-y-1 h-full overflow-y-auto">
                        @foreach ($post->comments as $comment)
                            <x-social.partials.comment-list-item :comment="$comment" />
                        @endforeach
                        @if ($recentlyAddedComment)
                            <x-social.partials.comment-list-item :comment="$recentlyAddedComment" />
                        @endif
                    </ul>
                </section>
                <footer class="flex justify-center bg-transparent border-t border-gray-200">
                    <form action="#" class="relative w-full" wire:submit.prevent="saveComment">
                        <!-- Spacer element to match the height of the toolbar -->
                        <div class="py-2" aria-hidden="true">
                            <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                            <div class="py-px">
                                <div class="h-9"></div>
                            </div>
                        </div>
                        <div class="flex-1 px-2 rounded-lg overflow-hidden">
                            <label for="body" class="sr-only">What's going on?</label>
                            <input 
                                type="text"  name="body" id="body" 
                                class="block w-full py-3 border-y border-gray-500 resize-none focus:ring-0 sm:text-sm" 
                                wire:model.defer="body"
                            >
                            @error('body') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex">
                            <div class="ml-auto">
                                <button 
                                    type="submit" 
                                    class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >Comment</button>
                            </div>
                        </div>
                    </form>
                </footer>
            </div>
        </div>
    </div>
</div>
