<div
        x-data="{
        current: 'map'
    }"
>
    <x-library::heading.3 class="uppercase">{{ \Trans::get('Find Teams') }}</x-library::heading.3>

    <div class="bg-white flex justify-between items-center mt-2 px-4 py-3">
        <div class="flex items-center">
            <button x-show="current === 'map'" x-on:click.prevent="current = 'calendar'" type="button" class="mr-4">
                <x-heroicon-o-calendar class="w-5 h-5"/>
            </button>

            <button x-show="current === 'calendar'" x-on:click.prevent="current = 'map'" type="button" class="mr-4" style="display: none">
                <x-heroicon-o-map class="w-5 h-5"/>
            </button>

            <x-jet-dropdown align="left" width="72" wid contentClasses="p-2 bg-white" closeOnClick="false">
                <x-slot name="trigger">
                    <div class="flex items-center space-x-1 cursor-pointer">
                        <x-heroicon-o-filter class="w-5 h-5"/>
                        <p>{{ \Trans::get('Filter') }}</p>
                    </div>
                </x-slot>
                <x-slot name="content">
                    <div class="space-y-2">
                        <div>
                            <x-library::input.label value="Start Date" class="font-bold"/>
                            <x-library::input.date id="start-date" wire:model="startDate" placeholder="{{ \Trans::get('Team Launch Date') }}"/>
                        </div>
                    </div>
                </x-slot>
            </x-jet-dropdown>
        </div>
        <p>
            <a href="{{ route('social.teams.map') }}" class="font-bold">{{ \Trans::get('View All Teams') }}</a>
        </p>
    </div>

    <div x-show="current === 'map'">
        <livewire:social::components.team-map/>
    </div>

    <div x-show="current === 'calendar'" class="bg-white h-80 px-4">
        <livewire:social::components.current-week-team-calendar
                before-calendar-view="calendar-views.header"
                event-view="calendar-views.event-item"
        />
    </div>
</div>
