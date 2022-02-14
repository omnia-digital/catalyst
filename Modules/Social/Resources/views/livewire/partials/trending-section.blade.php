<section aria-labelledby="trending-heading">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 id="trending-heading" class="text-base font-medium text-gray-900">
                Trending
            </h2>
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-4 divide-y divide-gray-200">
                    @foreach ($trendingPosts as $post)
                        <li class="flex py-4 space-x-3">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8 rounded-full" src="{{ $post['user']['imageUrl'] }}" alt="{{ $post['user']['name'] }}"/>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-gray-800">{{ $post['body'] }}</p>
                                <div class="mt-2 flex">
                                                    <span class="inline-flex items-center text-sm">
                                                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                                                            <x-heroicon-o-chat-alt class="h-5 w-5" aria-hidden="true" />
                                                            <span class="font-medium text-gray-900">{{ $post['comments'] }}</span>
                                                        </button>
                                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6">
                <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    View all
                </a>
            </div>
        </div>
    </div>
</section>
