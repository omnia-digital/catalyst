<article wire:click.prevent.stop="showPost"
    class="w-full sm:max-w-post-card-max-w bg-post-card-bg-color pt-4 shadow rounded-lg z-10{{ $clickable ? 'cursor-pointer' : '' }}"
>
    <div class="flex justify-between px-5">
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $post->user?->profile_photo_url }}" alt="{{ $post->user->name }}"/>
            </div>
            <div class="min-w-0 flex-1">
                <div class="min-w-0">
                    <div class="font leading-5">
                        <a wire:click.prevent.stop="showProfile" href="{{ route('social.profile.show', $post->user->handle) }}"
                           class="hover:underline block font-bold text-post-card-title-color">{{ $post->user->name }}</a>
                    </div>
                    <div class="flex content-center space-x-1 items-center text-post-card-body-color">
                        <a wire:click.prevent.stop="showProfile" href="{{ route('social.profile.show', $post->user->handle) }}" class="">{{ '@'. $post->user->handle }}</a>
                        <x-dot/>
                        <a href="{{ $post->getUrl() }}" class="hover:underline">
                            <time datetime="{{ $post->published_at }}">{{ $post->published_at?->diffForHumans(short: true) }}</time>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="z-1 flex align-top space-x-4">
            @if (!is_null($post->team_id))
                <div class="hidden xl:flex items-center space-x-2 h-7">
                    <div class="flex-shrink-0">
                        <img class="h-7 w-7 rounded-full" src="{{ $post->team?->profile_photo_url }}" alt="{{ $post->team->name }}"/>
                    </div>
                    <div class="text-post-card-body-color text-xs font-semibold mr-3">
                        <a wire:click.prevent.stop="showProfile('{{ $post->team->handle }}', true)"
                           href="{{ route('social.teams.show', $post->team->handle) }}" class="hover:underline">{{ $post->team->name }}</a>
                    </div>
                </div>
            @endif
            <div class="relative z-1 inline-block text-left items-center">
                <x-library::dropdown>
                    <x-slot name="trigger" x-on:click.stop="">
                        <button type="button" class="-m-2 p-2 rounded-full flex items-center text-post-card-title-color hover:text-light-text-color" id="menu-0-button" aria-expanded="false"
                                aria-haspopup="true">
                            <span class="sr-only">Open options</span>
                            <x-heroicon-s-dots-horizontal class="h-5 w-5"/>
                        </button>
                    </x-slot>
                    <x-library::dropdown.item wire:click.prevent.stop="toggleBookmark">
                        <div class="flex items-center space-x-1">
                            <x-heroicon-o-bookmark class="h-6 w-6" aria-hidden="true"/>
                            <p>{{ $post->isBookmarkedBy() ? 'Un-bookmark' : 'Bookmark' }}</p>
                        </div>
                    </x-library::dropdown.item>
                    @can('update', $post)
                        <a
                            x-data x-on:click.stop=""
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 disabled:text-base-text-color"
                            href="{{ route('social.posts.edit', $post->id) }}"
                        >
                            <div class="flex items-center space-x-1">
                                <x-heroicon-o-pencil-alt class="h-6 w-6" aria-hidden="true"/>
                                <span>Edit</span>
                            </div>
                        </a>
                    @endcan
                    @can('delete', $post)
                        <livewire:social::delete-post-dropdown-item :post="$post" wire:key="delete-post-dropdown-item{{ $post->id }}" :show="true"/>
                    @endcan
                </x-library::dropdown>
            </div>
        </div>
    </div>

    <div class="w-full mt-1 px-5 overflow-hidden ">
        {!! $post->body !!}
    </div>

    @if ($post->image)
        <div class="mt-3 block w-full aspect-w-10 aspect-h-3  overflow-hidden">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
        </div>
    @endif

    @if ($post->media ?? null)
        <div class="mt-3 overflow-hidden">
            <div class="grid grid-cols-{{ sizeof($post->media) > 1 ? '2' : '1' }} grid-rows-{{ sizeof($post->media) > 2 ? '2 h-80' : '1' }} gap-px">
                @foreach ($post->media as $media)
                    <div class="w-full overflow-hidden @if ($loop->first && sizeof($post->media) == 3) row-span-2 fill-row-span @endif">
                        <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="object-cover w-full">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div>
        @if ($post->isRepost())
            <article class="mt-4 w-full flex bg-post-card-bg-color p-4 shadow-sm border border-post-card-border-color rounded-md">
                <div class="mr-3 flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ $post->repostOriginal->user?->profile_photo_url }}" alt="{{ $post->repostOriginal->user->name }}"/>
                </div>
                <div class="flex-1">
                    <div class="flex space-x-3">
                        <div class="min-w-0 flex-1">
                            <div class="min-w-0 flex justify-start">
                                <div class="font-bold text-dark-text-color mr-2">
                                    <a wire:click.prevent.stop="showProfile('{{ $post->repostOriginal->user->handle }}')"
                                       href="{{ route('social.profile.show', $post->repostOriginal->user->handle) }}" class="hover:underline">{{ $post->repostOriginal->user->name }}</a>
                                </div>
                                <div class="text-base-text-color">
                                    {{ $post->repostOriginal->published_at?->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        {!! $post->repostOriginal->body !!}
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

    @if ($showPostActions)
        <div wire:click.prevent.stop="" class="z-20 px-5">
            <livewire:social::partials.post-actions wire:key="post-actions-{{ $post->id }}" :post="$post"/>
        </div>
    @endif
</article>
