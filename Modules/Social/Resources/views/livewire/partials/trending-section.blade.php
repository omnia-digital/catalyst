<section aria-labelledby="trending-heading">
        <div class="">
            <h2 id="trending-heading" class="p-3 text-xl font-medium text-dark-text-color">
                {{ $title }}
            </h2>
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-4">
                    @foreach ($posts as $post)
                        <li class="p-4 hover:bg-neutral-hover">
                        <a href="{{ route('social.posts.show', ['post' => $post]) }}" class="flex justify-between">
                            <div class="flex-1">
                                <div class="font-bold">
                                    {{ $post->title ?? $post->user->name }}
                                </div>
                                <div class="line-clamp-2">
                                    {!! Purify::clean($post->body) !!}
                                </div>
                            </div>
                            <div class="w-1/6">
                                <img class="rounded-lg flex-shrink-0 h-full object-cover" src="{{ $post->main_image }}" alt="{{ $post->user->name }}"/>
                            </div>
                        </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6">
                <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-dark-text-color bg-primary hover:bg-gray-50">
                    View all
                </a>
            </div>
        </div>
</section>
