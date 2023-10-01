<div class="py-12 bg-transparent">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
            <!-- Filters -->
            @include('playlist.partials.filters', ['speaker' => $speakers])

            <div class="flex-1 flex items-stretch overflow-hidden">
                <!-- List of Episodes -->
                <main class="flex-1 overflow-y-auto">
                    <div class="pt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Sort By menu for mobile -->
                        <div class="mt-3 sm:mt-2">
                            {{--                            <div class="sm:hidden">--}}
                            {{--                                <label for="sort-by" class="sr-only">Sort By</label>--}}
                            {{--                                <select wire:model.live="orderBy" id="sort-by" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">--}}
                            {{--                                    <option value="date_recorded">Recently Added</option>--}}
                            {{--                                    <option value="views">Most Viewed</option>--}}
                            {{--                                </select>--}}
                            {{--                            </div>--}}

                            <div class="hidden sm:block">
                                <div class="flex items-center">
                                    {{--                                    <nav class="flex-1 -mb-px flex space-x-6 xl:space-x-8" aria-label="Tabs">--}}
                                    {{--                                        <x-episode.sort-button key="date_recorded" :orderBy="$orderBy">--}}
                                    {{--                                            Recently Added--}}
                                    {{--                                        </x-episode.sort-button>--}}

                                    {{--                                        <x-episode.sort-button key="views" :orderBy="$orderBy">--}}
                                    {{--                                            Most Viewed--}}
                                    {{--                                        </x-episode.sort-button>--}}
                                    {{--                                    </nav>--}}
                                </div>
                            </div>
                        </div>

                        <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
                            @if ($episodes->count() > 0)
                                <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6">
                                    @foreach ($episodes as $episode)
                                        @if (empty($episode?->video) || $episode?->video?->isAudio())
                                            <x-playlist.audio-episode-item wire:key="episode-{{ $episode->id }}"
                                                                           :episode="$episode"
                                                                           :first="$loop->first && $episodes->currentPage() === 1"/>
                                        @else
                                            <x-episode.list-item
                                                    wire:key="episode-{{ $episode->id }}"
                                                    :episode="$episode"
                                                    first="{{ $loop->first }}"
                                            />
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <x-episode.empty/>
                            @endif
                        </section>

                        <div class="pb-6">
                            {{ $episodes->links('playlist.embed.pagination') }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>

