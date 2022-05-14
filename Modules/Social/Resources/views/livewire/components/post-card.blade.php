<article wire:click.prevent.stop="showPost" class="flex justify-start bg-primary pl-3 pr-5 pt-4 shadow-sm rounded-lg cursor-pointer border border-2 border-transparent hover:border-secondary z-10">
    <div class="mr-3 flex-shrink-0">
        <img class="h-10 w-10 rounded-full" src="{{ $post->user?->profile_photo_url }}" alt="{{ $post->user->profile->name }}"/>
    </div>
    <div class="flex-1">
        <div class="flex space-x-3">
            <div class="min-w-0 flex-1">
                <div class="min-w-0">
                    <div class="mr-2 font leading-5">
                        <a href="{{ route('social.profile.show', $post->user->handle) }}" class="hover:underline block font-bold text-dark-text-color">{{ $post->user->name }}</a>

                    </div>
                    <div class="flex content-center space-x-1 text-base-text-color">
                        <a href="{{ route('social.profile.show', $post->user->handle) }}" class="">{{ '@'. $post->user->handle }}</a>
                        <x-dot/>
                        <a href="{{ $post->getUrl() }}" class="hover:underline">
                            <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans(short: true) }}</time>
                        </a>
                    </div>
                </div>
            </div>

            <div class=" flex align-top">
{{--                @if (!is_null($post->team_id))--}}
{{--                    <div class="text-base-text-color text-xs font-semibold mr-3">--}}
{{--                        <a href="{{ $post->team->projectLink() }}" class=" hover:no-underline">{{ $post->team->name }}</a>--}}
{{--                    </div>--}}
{{--                @endif--}}
                <div class="relative z-1 inline-block text-left">
                    <x-library::dropdown>
                        <x-slot name="trigger" x-on:click.stop="">
                            <button type="button" class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open options</span>
                                <x-heroicon-s-dots-horizontal class="h-5 w-5"/>
                            </button>
                        </x-slot>
                        <x-library::dropdown.item wire:click.prevent.stop="toggleBookmark">
                            {{ $post->isBookmarkedBy() ? 'Un-bookmark' : 'Bookmark' }}
                        </x-library::dropdown.item>
                    </x-library::dropdown>
                </div>
            </div>
        </div>

        <div class="w-full mt-1">
            {!! Purify::clean($post->body) !!}
        </div>

        @if ($post->image)
            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
            </div>
        @endif

        @if ($post->media ?? null)
            <div class="mt-3 rounded-lg overflow-hidden">
                <div class="grid grid-cols-{{ sizeof($post->media) > 1 ? '2' : '1' }} grid-rows-{{ sizeof($post->media) > 2 ? '2 h-80' : '1' }} gap-px">
                    @foreach ($post->media as $media)
                        <div class="w-full overflow-hidden @if($loop->first && sizeof($post->media) == 3) row-span-2 fill-row-span @endif">
                            <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="object-cover w-full">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            @if ($post->isRepost())
                <article class="mt-4 w-full flex bg-white p-4 shadow-sm border border-gray-200 rounded-md">
                    <div class="mr-3 flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ $post->repostOriginal->user?->profile_photo_url }}" alt="{{ $post->repostOriginal->user->profile->name }}"/>
                    </div>
                    <div class="flex-1">
                        <div class="flex space-x-3">
                            <div class="min-w-0 flex-1">
                                <div class="min-w-0 flex justify-start">
                                    <div class="font-bold text-dark-text-color mr-2">
                                        <a href="{{ route('social.profile.show', $post->repostOriginal->user->handle) }}" class="hover:underline">{{ $post->repostOriginal->user->name }}</a>
                                    </div>
                                    <div class="text-base-text-color">
                                        {{ $post->repostOriginal->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            {!! Purify::clean($post->repostOriginal->body) !!}
                        </div>

                        @if ($post->repostOriginal->image)
                            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                                <img src="{{ $post->repostOriginal->image }}" alt="{{ $post->repostOriginal->title }}" class="object-cover">
                            </div>
                        @endif

                        @if ($media = $post->repostOriginal->media[0] ?? null)
                            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                                <img src="{{ $media->getUrl() }}" alt="{{ $post->repostOriginal->title }}" class="object-cover">
                            </div>
                        @endif
                    </div>
                </article>
            @endif
        </div>

        <div class="z-20">
            <livewire:social::partials.post-actions wire:key="post-actions-{{ $post->id }}" :post="$post"/>
        </div>
    </div>
</article>
