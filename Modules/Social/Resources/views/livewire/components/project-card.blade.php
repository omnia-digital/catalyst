<div class="bg-primary border border-neutral-light rounded hover-trigger relative bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat">
    <div class="h-80 rounded"></div>
    <div class="space-y-2 p-4 bg-primary rounded absolute bottom-0 right-0 left-0">
        <div class="flex justify-between">
            <p class="text-dark-text-color font-semibold text-base">{{ $project->name }}</p>
            <div class="flex items-center">
                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                <p>{{ $project->allUsers()->count() }}</p>
            </div>
        </div>
        <div class="flex items-center text-base-text-color">
            @isset($project->teamLocation)
                <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                <span class="text-dark-text-color text-xs">{{ $project->location }}</span>
            @endisset
        </div>
        <p class="text-light-text-color text-xs line-clamp-3 hover-slide-up">{{ $project->summary }}</p>
    </div>
    <a href="{{ $project->profile() }}" class="stretched-link"></a>
</div>