<div>
    <div class="flex flex-wrap-reverse sm:flex-nowrap">

        <div x-data="{openMobileTeams: false}" class="sm:h-full-minus-[56px] w-full sm:w-fit">
            <livewire:social::components.team-calendar-list classes="shrink hidden mx-auto sm:block sm:mx-0 sm:static" />
            <div class="absolute left-0 bottom-0 right-0 z-10 bg-primary p-4">
                <button class="w-full flex justify-center items-center py-2 px-4 mx-2 text-sm rounded-md bg-transparent border-2 border-secondary text-secondary hover:bg-neutral-light active:bg-neutral-light focus:bg-neutral-light">
                    <span class="ml-2">{{ \Trans::get('Teams') }}</span>
                </button>
            </div>
        </div>
        <div class="flex-1 mr-2 p-2">
            <livewire:social::components.team-calendar
                before-calendar-view="calendar-views.header"
                event-view="calendar-views.event-item"
            />
        </div>
    </div>
</div>
