<div wire:click.prevent.stop="showProject" class="bg-primary border border-neutral-light rounded group relative bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat hover:cursor-pointer hover:ring-1 hover:ring-black">
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
            @isset($project->location)
                <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
                <span class="text-dark-text-color text-xs">{{ $project->location }}</span>
            @endisset
        </div>
        <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $project->summary }}</p>
    </div>
</div>
