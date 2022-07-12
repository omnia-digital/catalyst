<div class="h-full z-20 absolute left-0 top-0 w-1/3 min-w-[295px] p-2">
    <div class="flex flex-col sticky h-full top-20 inset-y-2">
        <div class="h-full flex flex-col">
            <div class="bg-primary flex justify-between items-center text-xl h-16 px-4">
                <div class="font-medium">
                    <div class="text-xl">{{ \Trans::get('Teams') }}</div>
                </div>
                <div class="flex items-center space-x-4">
                        <a href="{{ route('social.teams.map') }}" @class([
		                    'text-light-text-color hover:text-secondary active:text-secondary focus:text-secondary',
		                    'text-secondary' => request()->routeIs('social.teams.map')
]                       )>
                            <span class="sr-only" x-text="'Map'"></span>
                            <span><x-heroicon-o-map class="h-6 w-6" /></span>
                        </a>
                        <a href="{{ route('social.teams.calendar') }}" @class([
		                    'text-light-text-color hover:text-secondary active:text-secondary focus:text-secondary',
		                    'text-secondary' => request()->routeIs('social.teams.calendar')
]                       )>
                            <span class="sr-only" x-text="'Calendar'"></span>
                            <span><x-heroicon-o-calendar class="h-6 w-6" /></span>
                        </a>
                </div>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters-sm')

            <div class="bg-primary space-y-2 pt-4 flex-1 overflow-y-scroll scrollbar-hide">
                @forelse ($teams as $team)
                    <div
                        class="space-y-2 mx-2 p-4 bg-primary rounded-lg border border-neutral cursor-pointer
                            {{ ($selectedID === $team->id) ? 'shadow-md ring-1 ring-neutral-dark' : '' }}
                            hover:shadow-lg  hover:ring-2 hover:ring-neutral-dark active:shadow-lg active:ring-2 active:ring-neutral-dark focus:shadow-lg focus:ring-2 focus:ring-neutral-dark"
                        wire:click="selectEvent({{ $team->id }})"
                    >
                        <div class="flex justify-between">
                            <p class="text-dark-text-color font-semibold text-base">{{ $team->name }}</p>

                        </div>
                        <div class="flex items-center text-base-text-color">
                            @isset($team->location)
                                <x-heroicon-o-location-marker class="h-4 w-4 mr-2" />
                                <span class="text-dark-text-color text-xs">{{ $team->location }}</span>
                            @endisset
                        </div>
                        <p class="text-light-text-color text-xs line-clamp-3">{{ $team->summary }}</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>{{ $team->users()->count() }}</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>{{ $team->start_date?->toFormattedDateString() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>No {{ \Trans::get('teams') }} to show</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
