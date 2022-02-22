<span class="inline-flex items-center text-sm" x-data="{ commentsModalOpen: false }">
    <button type="button" 
        class="inline-flex space-x-2 text-gray-400 hover:text-gray-500"
        @click="commentsModalOpen = true"
    >
        {{ $slot }}
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
                <header class="flex flex-row justify-between p-6 bg-white border-b border-gray-200">
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
                            <li>
                                <div>
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" />
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('profile.show') }}" class="hover:underline">{{ $comment->user->name }}</a>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                <a href="#" class="hover:underline">
                                                    <time datetime="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</time>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm text-gray-700 space-y-4">{{ $comment->body }}</div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
        </div>
    </div>
</span>
