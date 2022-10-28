@props([
    'team'
])

<a href="{{ route('social.teams.show', $team) }}">
    <div class="bg-primary border border-neutral-light rounded hover-trigger relative bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
        <div class="h-80 rounded"></div>
        <div class="space-y-2 p-4 bg-primary rounded absolute bottom-0 right-0 left-0">
            <div class="flex justify-between">
                <p class="text-dark-text-color font-semibold text-base">{{ $team->name }}</p>
                <div class="flex items-center">
                    <x-heroicon-o-users class="h-4 w-4 mr-2"/>
                    <p>{{ $team->members ?? 'Unknown' }}</p>
                </div>
            </div>
            <div class="flex items-center text-base-text-color">
                <x-heroicon-o-location-marker class="h-5 w-5 mr-2"/>
                <span class="text-dark-text-color text-xs">{{ $team->location?->name ?? 'Not set' }}</span>
            </div>
            <p class="text-light-text-color text-xs line-clamp-3 hover-slide-up">{{ $team->summary }}</p>
        </div>
    </div>
</a>
