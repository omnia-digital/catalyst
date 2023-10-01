<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Header -->
            <x-panel-header :route="route('episodes.create')" title="Episodes" icon="heroicon-o-upload"/>

            <!-- Filters -->
            @include('episode.partials.filters', ['speaker' => $speakers])

            <div class="flex-1 flex items-stretch overflow-hidden">
                <!-- List of Episodes -->
                <main class="flex-1 overflow-y-auto">
                    <div class="pt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex">
                            <div class="mr-2 bg-gray-100 py-0.5 px-1 rounded-lg flex items-center sm:hidden">
                                @if (auth()->user()->email === 'admin@omniadigital.io')
                                    <button title="Mass Upload" wire:click="toggleMassAttachmentUpload" type="button"
                                            class="p-1.5 rounded-md {{ $massAttachmentUpload ? 'bg-white text-blue-500' : 'hover:bg-white text-gray-400' }} hover:shadow-sm">
                                        <x-heroicon-s-upload class="h-5 w-5"/>
                                        <span class="sr-only">Mass Attachment Upload</span>
                                    </button>
                                @endif
                                <button title="Multi-select" wire:click="toggleMultiSelect" type="button"
                                        class="p-1.5 rounded-md {{ $multiSelectMode ? 'bg-white text-blue-500' : 'hover:bg-white text-gray-400' }} hover:shadow-sm">
                                    <x-heroicon-s-pencil-alt class="h-5 w-5"/>
                                    <span class="sr-only">Multiselect Mode</span>
                                </button>
                            </div>
                            <div class="mr-6 bg-gray-100 p-0.5 rounded-lg flex items-center sm:hidden">
                                <button wire:click="switchLayout('list')" type="button"
                                        class="p-1.5 rounded-md text-gray-400 {{ $this->isUsingListLayout() ? 'bg-white' : 'hover:bg-white' }} hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <x-heroicon-s-view-list class="h-5 w-5"/>
                                    <span class="sr-only">Use list view</span>
                                </button>
                                <button wire:click="switchLayout('grid')" type="button"
                                        class="ml-0.5 {{ $this->isUsingGridLayout() ? 'bg-white' : 'hover:bg-white' }} p-1.5 rounded-md shadow-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                    <x-heroicon-s-view-grid class="h-5 w-5"/>
                                    <span class="sr-only">Use grid view</span>
                                </button>
                            </div>
                            <!-- Sort By menu for mobile -->
                            <div class="flex-1 sm:hidden">
                                <label for="sort-by" class="sr-only">Sort By</label>
                                <select wire:model.live="orderBy" id="sort-by" name="tabs"
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="date_recorded">Recently Added</option>
                                    <option value="views">Most Viewed</option>
                                </select>
                            </div>
                        </div>

                        <div class="hidden sm:block">
                            <div class="flex items-center border-b border-gray-100">
                                <nav class="flex-1 -mb-px flex space-x-6 xl:space-x-8" aria-label="Tabs">
                                    <x-episode.sort-button key="date_recorded" :orderBy="$orderBy">
                                        Recently Added
                                    </x-episode.sort-button>

                                    <x-episode.sort-button key="views" :orderBy="$orderBy">
                                        Most Viewed
                                    </x-episode.sort-button>
                                </nav>
                                <div class="hidden ml-6 bg-gray-100 p-0.5 rounded-lg items-center sm:flex">
                                    @if (auth()->user()->email === 'admin@omniadigital.io')
                                        <button title="Mass Upload" wire:click="toggleMassAttachmentUpload"
                                                type="button"
                                                class="p-1.5 rounded-md {{ $massAttachmentUpload ? 'bg-white text-blue-500' : 'hover:bg-white text-gray-400' }} hover:shadow-sm">
                                            <x-heroicon-s-upload class="h-5 w-5"/>
                                            <span class="sr-only">Mass Attachment Upload</span>
                                        </button>
                                    @endif
                                    <button title="Multi-select" wire:click="toggleMultiSelect" type="button"
                                            class="p-1.5 rounded-md {{ $multiSelectMode ? 'bg-white text-blue-500' : 'hover:bg-white text-gray-400' }} hover:shadow-sm">
                                        <x-heroicon-s-pencil-alt class="h-5 w-5"/>
                                        <span class="sr-only">Multiselect Mode</span>
                                    </button>
                                </div>
                                <div class="hidden ml-6 bg-gray-100 p-0.5 rounded-lg items-center sm:flex">
                                    <button wire:click="switchLayout('list')" type="button"
                                            class="p-1.5 rounded-md text-gray-400 {{ $this->isUsingListLayout() ? 'bg-white' : 'hover:bg-white' }} hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                        <x-heroicon-s-view-list class="h-5 w-5"/>
                                        <span class="sr-only">Use list view</span>
                                    </button>
                                    <button wire:click="switchLayout('grid')" type="button"
                                            class="ml-0.5 {{ $this->isUsingGridLayout() ? 'bg-white' : 'hover:bg-white' }} p-1.5 rounded-md shadow-sm text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                        <x-heroicon-s-view-grid class="h-5 w-5"/>
                                        <span class="sr-only">Use grid view</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
                            @if ($episodes->count() > 0)
                                @if ($this->isUsingGridLayout())
                                    <ul role="list"
                                        class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6  md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 xl:gap-x-8">
                                        @foreach ($episodes as $episode)
                                            <x-episode.grid-item
                                                    wire:key="episode-{{ $episode->id }}"
                                                    wire:click="selectEpisode({{ $episode->id }})"
                                                    :class="in_array($episode->id, $selectedIDs) ? 'ring-1 ring-offset-4 ring-blue-500' : ''"
                                                    :episode="$episode"
                                                    :selected="$episode->id === $selectedEpisode"
                                            />
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6">
                                        @foreach ($episodes as $episode)
                                            @if ($episode?->video?->isAudio())
                                                <x-playlist.audio-episode-item
                                                        wire:key="episode-{{ $episode->id }}"
                                                        wire:click="selectEpisode({{ $episode->id }})"
                                                        :episode="$episode"
                                                        :class="in_array($episode->id, $selectedIDs) ? 'ring-1 ring-offset-4 ring-blue-500' : ''"
                                                        :selected="$episode->id === $selectedEpisode"
                                                        public="false"
                                                />
                                            @else
                                                <x-episode.list-item
                                                        wire:key="episode-{{ $episode->id }}"
                                                        wire:click="selectEpisode({{ $episode->id }})"
                                                        :episode="$episode"
                                                        :class="in_array($episode->id, $selectedIDs) ? 'ring-1 ring-offset-4 ring-blue-500' : ''"
                                                        :selected="$episode->id === $selectedEpisode"
                                                        public="false"
                                                />
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            @else
                                <x-episode.empty/>
                            @endif
                        </section>

                        <div class="pb-6">
                            {{ $episodes->onEachSide(1)->links() }}
                        </div>
                    </div>
                </main>

                <!-- Episode Detail -->
                @include('episode.partials.episode-detail', [
                    'selectedEpisode' => $selectedEpisode,
                    'selectedIDs' => $selectedIDs
                ])
            </div>
        </div>
    </div>
</div>
