<div>
    <div class="flex">

        <div x-data="{openMobileTeams: false}" class="sm:h-full-minus-[56px] relative">
            <div :class="openMobileTeams ? 'z-10 left-0 top-0 bg-neutral' : 'left-[-395px]'" class="h-full absolute sm:block sm:z-0 sm:static transition-all delay-75 duration-300">
                <livewire:social::components.teams.team-calendar-list />
            </div>
            <div class="flex sm:hidden justify-center items-center fixed bottom-4 right-4 z-20 bg-transparent p-px w-12 h-12">
                <button
                    x-on:click="openMobileTeams = !openMobileTeams"
                    class="flex justify-center items-center p-3 text-sm rounded-full bg-secondary border border-primary text-primary hover:bg-neutral-light active:bg-neutral-light focus:bg-neutral-light">
                    <x-heroicon-o-collection class="w-4 h-4" />
                </button>
            </div>
        </div>
        <div class="flex-1 mr-2 p-2">
            <livewire:social::components.teams.team-calendar
                before-calendar-view="calendar-views.header"
                event-view="calendar-views.event-item"
            />
        </div>
    </div>
</div>
