<div class="bg-primary border border-neutral-light rounded hover:scale-110 transition ease-in-out delay-150 duration-300">
    <div class="h-36 rounded-t bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
    <div class="space-y-2 p-4">
        <div class="flex justify-between">
            <p class="text-dark-text-color font-semibold text-base">{{ $project->title }}</p>
            <div class="flex items-center">
                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                <p>{{ $project->users()->count() }}</p>
            </div>
        </div>
        <div class="flex items-center text-base-text-color">
            <x-heroicon-o-location-marker class="h-5 w-5 mr-2" />
            <span class="text-dark-text-color text-xs">{{ $project->location }}</span>
        </div>
        <p class="text-light-text-color text-xs line-clamp-3">{{ $project->summary }}</p>
    </div>
</div>