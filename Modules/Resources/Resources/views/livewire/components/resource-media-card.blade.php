<div wire:click.prevent.stop="showTeam"
     class="w-full bg-secondary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
     style="background-image: url({{ $post->image ?? config('teams.defaults.cover_photo') }}); background-size: cover; background-repeat: no-repeat;"
>
    <div class="h-80 rounded"></div>
{{--    <div class="space-y-2 p-4 bg-secondary rounded absolute bottom-0 right-0 left-0">--}}
{{--        <div class="flex justify-between">--}}
{{--            <p class="text-dark-text-color font-semibold text-base">{{ $post->body }}</p>--}}
{{--            <div class="flex items-center">--}}
{{--                <div class="flex justify-end px-5">--}}
{{--                    <div class="flex items-center space-x-3">--}}
{{--                        <div class="flex-shrink-0">--}}
{{--                            <img class="h-10 w-10 rounded-full" src="{{ $post->user?->profile_photo_url }}" alt="{{ $post->user->name }}"/>--}}
{{--                        </div>--}}
{{--                        <div class="min-w-0 flex-1">--}}
{{--                            <div class="min-w-0">--}}
{{--                                <div class="font leading-5">--}}
{{--                                    <a wire:click.prevent.stop="showProfile" href="{{ route('social.profile.show', $post->user->handle) }}"--}}
{{--                                       class="hover:underline block font-bold text-post-card-title-color">{{ $post->user->name }}</a>--}}
{{--                                </div>--}}
{{--                                <div class="flex content-center space-x-1 items-center text-post-card-body-color">--}}
{{--                                    <a wire:click.prevent.stop="showProfile" href="{{ route('social.profile.show', $post->user->handle) }}" class="">{{ '@'. $post->user->handle }}</a>--}}
{{--                                    <x-dot/>--}}
{{--                                    <a href="{{ $post->getUrl() }}" class="hover:underline">--}}
{{--                                        <time datetime="{{ $post->published_at }}">{{ $post->published_at?->diffForHumans(short: true) }}</time>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="z-1 flex align-top space-x-4">--}}
{{--                        @if (!is_null($post->team_id))--}}
{{--                            <div class="hidden xl:flex items-center space-x-2 h-7">--}}
{{--                                <div class="flex-shrink-0">--}}
{{--                                    <img class="h-7 w-7 rounded-full" src="{{ $post->team?->profile_photo_url }}" alt="{{ $post->team->name }}"/>--}}
{{--                                </div>--}}
{{--                                <div class="text-post-card-body-color text-xs font-semibold mr-3">--}}
{{--                                    <a wire:click.prevent.stop="showProfile('{{ $post->team->handle }}', true)"--}}
{{--                                       href="{{ route('social.teams.show', $post->team->handle) }}" class="hover:underline">{{ $post->team->name }}</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="relative z-1 inline-block text-left items-center">--}}
{{--                            <x-library::dropdown>--}}
{{--                                <x-slot name="trigger" x-on:click.stop="">--}}
{{--                                    <button type="button" class="-m-2 p-2 rounded-full flex items-center text-post-card-title-color hover:text-light-text-color" id="menu-0-button"--}}
{{--                                            aria-expanded="false"--}}
{{--                                            aria-haspopup="true">--}}
{{--                                        <span class="sr-only">Open options</span>--}}
{{--                                        <x-heroicon-s-dots-horizontal class="h-5 w-5"/>--}}
{{--                                    </button>--}}
{{--                                </x-slot>--}}
{{--                                <x-library::dropdown.item wire:click.prevent.stop="toggleBookmark">--}}
{{--                                    <div class="flex items-center space-x-1">--}}
{{--                                        <x-heroicon-o-bookmark class="h-6 w-6" aria-hidden="true"/>--}}
{{--                                        <p>{{ $post->isBookmarkedBy() ? 'Un-bookmark' : 'Bookmark' }}</p>--}}
{{--                                    </div>--}}
{{--                                </x-library::dropdown.item>--}}
{{--                                @can('update', $post)--}}
{{--                                    <a--}}
{{--                                            x-data x-on:click.stop=""--}}
{{--                                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 disabled:text-base-text-color"--}}
{{--                                            href="{{ route('social.posts.edit', $post->id) }}"--}}
{{--                                    >--}}
{{--                                        <div class="flex items-center space-x-1">--}}
{{--                                            <x-heroicon-o-pencil-alt class="h-6 w-6" aria-hidden="true"/>--}}
{{--                                            <span>Edit</span>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                @endcan--}}
{{--                                @can('delete', $post)--}}
{{--                                    <livewire:social::delete-post-dropdown-item :post="$post" wire:key="delete-post-dropdown-item{{ $post->id }}" :show="true"/>--}}
{{--                                @endcan--}}
{{--                            </x-library::dropdown>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
