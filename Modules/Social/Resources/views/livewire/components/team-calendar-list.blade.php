<div>
    <div class="flex flex-col sticky h-screen overflow-y-scroll scrollbar-hide top-20 md:inset-y-2">
        <div>
            <div class="bg-primary flex justify-between items-center text-xl h-16 px-4 ">
                <div class="font-medium">
                    <div class="text-xl">{{ \Trans::get('Teams') }}</div>
                </div>
                <div class="flex items-center space-x-4">
                    <button role="button">
                        <x-heroicon-o-map class="w-6 h-6" />
                    </button>
                    <button role="button">
                        <x-heroicon-o-calendar class="w-6 h-6" />
                    </button>
                </div>
            </div>
            <div class="h-10 px-4 text-sm bg-neutral flex items-center justify-between">
                <button role="button" class="flex items-center"><span class="font-semibold mr-2">Sort:</span> By Date <x-heroicon-o-arrow-sm-down class="w-4 h-4" /></button>
                <button role="button" class="flex items-center"><x-heroicon-o-filter class="w-4 h-4" /><span class="ml-2 font-semibold">Filter</span></button>
            </div>
            <div class="bg-primary space-y-2 pt-4">
                @foreach ($teams as $team)
                    <div class="space-y-2 mx-2 p-4 bg-primary rounded-lg border border-neutral">
                        <div class="flex justify-between">
                            <p class="text-dark-text-color font-semibold text-base">{{ $team->title }}</p>
                            
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
                                <p>{{ $team->start_date->toFormattedDateString() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
