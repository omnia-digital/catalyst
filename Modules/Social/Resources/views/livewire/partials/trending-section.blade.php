<section aria-labelledby="trending-heading" class="card">
        <div class="">
            <h2 id="trending-heading" class="px-3 py-2 text-xl font-medium text-dark-text-color">
                {{ $title }}
            </h2>
            <div class="flow-root">
                <ul role="list" class="">
                    @foreach ($posts as $post)
                        <li class="py-3 px-4 hover:bg-neutral-hover">
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
                                <img class="rounded-lg flex-shrink-0 h-full object-cover" src="{{ $post->image ? $post->image : $post->user?->profile_photo_url }}" alt="{{ $post->user->name }}"/>
                            </div>
                        </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="">
                <a href="#" class="w-full block text-center px-4 py-4 shadow-sm text-sm font-medium rounded-md text-dark-text-color bg-primary hover:bg-neutral-hover">
                    View all
                </a>
            </div>
        </div>
</section>
