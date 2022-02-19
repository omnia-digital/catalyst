<span class="inline-flex items-center text-sm" x-data="{ commentsModalOpen: false }">
    <button type="button" 
        class="inline-flex space-x-2 text-gray-400 hover:text-gray-500"
        @click="commentsModalOpen = true"
    >
        {{ $slot }}
    </button>
    <div x-show="commentsModalOpen"
        class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"
        id="post-{{ $post->id }}-comments">
        <div class="absolute bg-black opacity-80 inset-0 z-0"></div>
        <div class="w-full max-w-5xl p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
            <!--content-->
            <div class="">
                <!--body-->
                <div
          class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg"
        >
            <p class="font-semibold text-gray-800">Comments</p>
            <button
                class=""
                @click="commentsModalOpen = false"
            >
                <x-heroicon-o-x class="w-6 h-6" />
                <span class="sr-only">Close</span>
            </button>
        </div>
        <div class="text-center p-5 flex-auto justify-center">
            <ul class="space-y-4 divide-y-1">
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
        </div>
    </div>
</span>
