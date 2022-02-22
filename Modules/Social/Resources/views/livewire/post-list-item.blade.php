<div class="bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <article aria-labelledby="{{ 'post-' . $post->id }}">
        <div>
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900">
                        <a href="{{ route('profile.show') }}" class="hover:underline">{{ $post->user->name }}</a>
                    </p>
                    <p class="text-sm text-gray-500">
                        <a href="{{ route('social.posts.show', $post) }}" class="hover:underline">
                            <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
                        </a>
                    </p>
                </div>
                <div class="flex-shrink-0 self-center flex">
                    <!-- Livewire Headless UI Menu -->
                    <div x-data="{ open: false }" class="relative inline-block text-left"> <!-- x-menu -->
                        <div>
                            <button 
                                class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600" 
                                type="button" 
                                aria-haspopup="true" 
                                aria-expanded="true" 
                                aria-controls="post-list-item-options-menu-items"
                                @click="open = true"
                            > <!-- x-menu-button -->
                                <span class="sr-only">Open options</span>
                                <x-heroicon-o-dots-vertical class="h-5 w-5" aria-hidden="true" />
                            </button>
                        </div>
                        <div 
                            id="post-list-item-options-menu-items" 
                            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                            x-show="open" @click.away="open = false"
                            x-transition:enter.duration.100ms
                            x-transition:enter.opacity.0
                            x-transition:enter.scale.95
                            x-transition:leave.duration.75ms
                            x-transition:leave.opacity.100
                            x-transition:leave.scale.100
                        > <!-- MenuItems -->
                            <div class="py-1">
                                <div> {{-- MenuItem v-slot="{ active }" --}}
                                    <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                        <x-heroicon-o-star class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                                        <span>Add to favorites</span>
                                    </a>
                                </div>
                                <div> {{-- MenuItem v-slot="{ active }" --}}
                                    <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                        <x-heroicon-o-code class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                                        <span>Embed</span>
                                    </a>
                                </div>
                                <div> {{-- MenuItem v-slot="{ active }" --}}
                                    <a href="#" class="text-gray-700 flex px-4 py-2 text-sm">
                                        <x-heroicon-o-flag class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true" />
                                        <span>Report content</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 id="{{ 'post-' . $post->id }}" class="mt-4 text-base font-medium text-gray-900">
                {{ $post->title }}
            </h2>
        </div>
        <div class="mt-2 text-sm text-gray-700 space-y-4">{{ $post->body }}</div>
        <div class="mt-6 flex justify-between space-x-8">
            <div class="flex space-x-6">
                <span class="inline-flex items-center text-sm">
                    <button class="inline-flex space-x-2 text-gray-400 hover:text-gray-500" wire:click="like">
                        @if ($post->isLiked)
                            <x-heroicon-s-thumb-up class="h-5 w-5" aria-hidden="true" />
                        @else
                            <x-heroicon-o-thumb-up class="h-5 w-5" aria-hidden="true" />
                        @endif
                        <span class="font-medium text-gray-900">{{ $post->likesCount() }}</span>
                        <span class="sr-only">likes</span>
                    </button>
                </span>
                
                <x-social.comments-modal :post="$post">
                    <x-heroicon-o-chat-alt class="h-5 w-5" aria-hidden="true" />
                    <span class="font-medium text-gray-900">{{ $post->comments()->count() }}</span>
                    <span class="sr-only">replies</span>
                </x-social.comments-modal>
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <x-heroicon-o-eye class="h-5 w-5" aria-hidden="true" />
                        <span class="font-medium text-gray-900">{{ $post->views }}</span>
                        <span class="sr-only">views</span>
                    </button>
                </span>
            </div>
            <div class="flex text-sm">
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                        <x-heroicon-o-share class="h-5 w-5" aria-hidden="true" />
                        <span class="font-medium text-gray-900">Share</span>
                    </button>
                </span>
            </div>
        </div>
    </article>
</div>
