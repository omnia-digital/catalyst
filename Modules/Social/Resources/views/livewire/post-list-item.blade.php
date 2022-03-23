<div
        class="bg-white pt-4 shadow sm:px-3 sm:rounded-lg"
        x-data="{ openOptions: false }"
>
{{--    <a href="{{ route('social.posts.show', ['post' => $post]) }}">--}}
        <article aria-labelledby="{{ 'post-' . $post->id }}" class="flex justify-start">
            <div class="mr-2">
                <img class="h-10 w-10 rounded-full" src="{{ $post->user?->profile_photo_url }}" alt="{{ $post->user->name }}"/>
            </div>
            <div class="flex-1">
                <div class="flex justify-between">
                    <div class="min-w-0 flex justify-start">
                        <div class="text-sm font-bold text-gray-900 mr-2">
                            <a href="{{ route('user.profile', $post->user->handle) }}" class="hover:underline">{{ $post->user->name }}</a>
                        </div>
                        <div class="text-sm text-gray-500">
                            <a href="{{ route('social.posts.show', $post) }}" class="hover:underline">
                                <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans(short: true) }}</time>
                            </a>
                        </div>
                    </div>
                    <div class="flex">
                        <!-- Livewire Headless UI Menu -->
                        <div class="relative inline-block text-left"> <!-- x-menu -->
                            <div>
                                <button
                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600"
                                        type="button"
                                        aria-haspopup="true"
                                        aria-expanded="true"
                                        id="post-list-item-{{ $post->id }}-options-menu-items"
                                        @click="openOptions = true"
                                > <!-- x-menu-button -->
                                    <span class="sr-only">Open options</span>
                                    <x-heroicon-o-dots-vertical class="h-5 w-5" aria-hidden="true"/>
                                </button>
                            </div>
                            <div
                                    aria-labelledby="post-list-item-{{ $post->id }}-options-menu-items"
                                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    x-show="openOptions" @click.away="openOptions = false"
                                    x-transition:enter.duration.100ms
                                    x-transition:enter.opacity.0
                                    x-transition:enter.scale.95
                                    x-transition:leave.duration.75ms
                                    x-transition:leave.opacity.100
                                    x-transition:leave.scale.100
                            > <!-- MenuItems -->
                                <div class="py-1">
                                    <div> <!-- MenuItem v-slot="{ active }" -->
                                        <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                            <x-heroicon-o-star class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                            <span>Add to favorites</span>
                                        </a>
                                    </div>
                                    <div> <!-- MenuItem v-slot="{ active }" -->
                                        <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                            <x-heroicon-o-code class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                            <span>Embed</span>
                                        </a>
                                    </div>
                                    <div> <!-- MenuItem v-slot="{ active }" -->
                                        <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                            <x-heroicon-o-flag class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                            <span>Report content</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-700">{{ $post->body }}</div>
                <livewire:social::partials.post-actions :post="$post"/>
            </div>
        </article>
{{--    </a>--}}
</div>
