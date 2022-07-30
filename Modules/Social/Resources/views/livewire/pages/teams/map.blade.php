<div>
    <div>
        <div x-data="{openMobileTeams: true}" class="relative overflow-hidden">
            <div :class="openMobileTeams ? 'z-20 left-0 top-0' : 'left-[-395px]'" class="h-full absolute w-1/3 transition-all delay-75 duration-300">
                <livewire:social::components.team-calendar-list />
            </div>
            <div class="flex justify-center items-center absolute bottom-4 right-4 z-20 bg-transparent p-px w-12 h-12">
                <button 
                    x-on:click="openMobileTeams = !openMobileTeams"
                    class="flex justify-center items-center p-3 text-sm rounded-full bg-primary border border-secondary text-secondary hover:bg-neutral-light active:bg-neutral-light focus:bg-neutral-light">
                    <x-heroicon-o-collection class="w-4 h-4" />
                </button>
            </div>
            <x-library::map.mapbox id="project-map" class="h-full-minus-[88px] z-10" :places="$places" mapStyle="mapbox://styles/mapbox/dark-v10"/>
        </div>
    </div>
</div>
