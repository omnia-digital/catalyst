<div>
    <div class="flex">
        <div class="h-full-minus-[56px]">
            <livewire:social::components.team-calendar-list class="testclass" />
        </div>
        <div class="flex-1 mr-10 p-2">
            <livewire:social::components.team-calendar
                before-calendar-view="calendar-views.header"
                event-view="calendar-views.event-item"
            />
        </div>
    </div>
</div>
