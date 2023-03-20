<div wire:click.prevent.stop="showTeam"
     class="w-full bg-secondary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
     style="background-image: url({{ $team->mainImage()->getFullUrl() ?? config('teams.defaults.cover_photo') }}); background-size: cover; background-repeat: no-repeat;"
>
    <div class="h-80 rounded"></div>
    <div class="space-y-2 p-4 bg-secondary rounded absolute bottom-0 right-0 left-0">
        <div class="flex justify-between">
            <p class="text-dark-text-color font-semibold text-base">{{ $team->name }}</p>
            <div class="flex items-center">
                @if($team->teamTypes->count() > 0)
                    <div class="flex items-center mr-2">
                        <x-library::icons.icon name="users" class="h-4 w-4 mr-2"/>
                        <x-tag name="{{ $team->teamTypes->first()?->name }}"/>
                    </div>
                @endif
                <div class="flex items-center">
                    <x-heroicon-o-users class="h-4 w-4 mr-2"/>
                    <p>{{ $team->users_count ?? $team->users()->count() }}</p>
                </div>
            </div>
        </div>
        <div class="flex items-center text-base-text-color">
            @isset($team->location)
                <x-heroicon-o-location-marker class="h-5 w-5 mr-2"/>
                <span class="text-dark-text-color text-xs">{{ $team->location }}</span>
            @endisset
        </div>
        <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $team->summary }}</p>
    </div>
</div>
