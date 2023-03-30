<article
    wire:click.prevent.stop="showPost"
    class="pt-4 shadow-sm rounded-lg cursor-pointer border-2 z-10 bg-secondary {{ $clickable ? 'cursor-pointer' : '' }}"
>
    <!-- Content -->
    <div class="w-full">
        <div class="space-y-1 lg:space-y-2">
            <div class="px-5 flex items-start justify-between">
                {{-- Left --}}
                <div class="min-w-0 flex-1">
                    <div class="min-w-0">
                        <h4 class="flex items-center">
                            <a href="{{ route('articles.show', ['article' => $post]) }}">{{ $post->title }}</a>
                        </h4>
                        <div class="flex content-center space-x-1 items-center text-post-card-body-color">
                            <p>by</p>
                            <a wire:click.prevent.stop="showProfile" href="{{ route('social.profile.show', $post->user->handle) }}"
                               class="hover:underline block font-bold text-post-card-title-color">{{ $post->user->name }}</a>
                            <x-dot/>
                            <a href="{{ $post->getUrl() }}" class="hover:underline">
                                <time datetime="{{ $post->published_at }}">{{ $post->published_at?->diffForHumans(short: true) }}</time>
                            </a>
                            @empty(!$post->is_verified)
                                <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                            @endempty
                        </div>
                    </div>
                </div>
                {{-- Right --}}
                <div class="flex lg:flex-shrink-0">
                    @if ($post->tags)
                        <div class="flex justify-start space-x-2 mr-2">
                            @foreach ($post->tags as $tag)
                                <x-tag :name="$tag->name"/>
                            @endforeach
                        </div>
                    @endif
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
                            @can('update', $post)
                                <a
                                    x-data x-on:click.stop=""
                                    class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 disabled:text-base-text-color"
                                    href="{{ route('articles.edit', $post->id) }}"
                                >
                                    Edit
                                </a>
                            @endcan
                        </x-library::dropdown>
                    </div>
                </div>
            </div>

            <div class="px-5 w-full line-clamp-5">
                {!! strip_tags($post->body) !!}
            </div>

            @if ($post->image)
                <div class="block w-full aspect-w-10 aspect-h-3 overflow-hidden">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
                </div>
            @endif

{{--            @if ($post->media ?? null)--}}
{{--                <div class="mt-3 overflow-hidden">--}}
{{--                    <div class="grid grid-cols-{{ sizeof($post->media) > 1 ? '2' : '1' }} grid-rows-{{ sizeof($post->media) > 2 ? '2 h-80' : '1' }} gap-px">--}}
{{--                        @foreach ($post->media as $media)--}}
{{--                            <div class="w-full overflow-hidden @if ($loop->first && sizeof($post->media) == 3) row-span-2 fill-row-span @endif">--}}
{{--                                <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="object-cover w-full">--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>

    <!-- Social Actions -->
    <div class="z-20 w-full px-5">
        <livewire:social::partials.post-actions :post="$post" :show-bookmark-button="true"/>
    </div>
</article>
