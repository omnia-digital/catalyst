<div wire:click.prevent.stop="showTeam"
    class="bg-primary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
    @if ($team->getMedia('team_main_images')->count())
        style="background-image: url({{ $team->getMedia('team_main_images')->first()->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
    @endif
>
    <div class="h-80 rounded"></div>
    <div class="space-y-2 p-4 bg-primary rounded absolute bottom-0 right-0 left-0">
        <div class="flex justify-between">
            <p class="text-dark-text-color font-semibold text-base">{{ $team->name }}</p>
            <div class="flex items-center">
                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                <p>{{ $team->allUsers()->count() }}</p>
            </div>
        </div>
        <div class="flex items-center text-base-text-color">
            @isset($team->location)
                <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                <span class="text-dark-text-color text-xs">{{ $team->location }}</span>
            @endisset
        </div>
        <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $team->summary }}</p>
    </div>
</div>
