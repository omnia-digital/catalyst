<div>
    <x-library::heading.3 class="uppercase">{{ \Trans::get('Find Teams') }}</x-library::heading.3>

    <div class="bg-white flex justify-between items-center mt-2 px-4 py-3">
        <div class="flex items-center space-x-4">
            <div>
                @if ($current === 'map')
                    <button wire:click.prevent="$set('current', 'calendar')" type="button">
                        <x-heroicon-o-calendar class="w-5 h-5"/>
                    </button>
                @else
                    <button wire:click.prevent="$set('current', 'map')" type="button">
                        <x-heroicon-o-map class="w-5 h-5"/>
                    </button>
                @endif
            </div>

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

    <div>
        @if ($current === 'map')
            <livewire:social::components.team-map/>
        @else
            <div class="bg-white h-80 px-4">
                <livewire:social::components.current-week-team-calendar
                        before-calendar-view="calendar-views.header"
                        event-view="calendar-views.event-item"
                />
            </div>
        @endif
    </div>
</div>
