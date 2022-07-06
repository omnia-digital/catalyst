<article wire:click.prevent.stop="showPost" class="pl-5 pr-5 pt-4 shadow-sm rounded-lg cursor-pointer border border-2 border-transparent hover:border-secondary z-10 bg-primary">
    <!-- Content -->
    <div class="w-full">
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 align-middle">
                    <h4 class="flex items-center">
                        <a href="{{ route('resources.show', ['resource' => $post]) }}">{{ $post->title }}</a>
                    </h4>

                    @empty(!$post->is_verified)
                        <x-heroicon-o-check-circle class="flex-shrink-0 w-6 h-6 inline-block  text-green-700 text-xs font-medium rounded-full"/>
                    @endempty

                    <h4 class="text-base-text-color text-md font-normal">{{ $post->created_at->diffInDays() < 2 ? $post->created_at->shortAbsoluteDiffForHumans() : $post->created_at->format('M d') }}</h4>
                </div>


                <div class="flex-shrink-0 self-center flex">
                    @if ($post->tags)
                        <div class="flex justify-start space-x-2 mr-2">
                            @foreach($post->tags as $tag)
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
                        </x-library::dropdown>
                    </div>
                </div>
            </div>

            <div class="w-full line-clamp-5">
                {!! $post->body !!}
            </div>

            @if($post->image)
                <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
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
        </div>
    </div>

    <!-- Social Actions -->
    <div class="z-20 w-full">
        <livewire:social::partials.post-actions :post="$post" :show-bookmark-button="true"/>
    </div>
</article>
