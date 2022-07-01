@extends('social::livewire.layouts.pages.team-calendar-layout')

@section('content')
    <div class="mt-6">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-3">
                <livewire:social::components.team-calendar-list />
            </div>
            <div 
                x-data="{ currentTab: @entangle('tab') }" 
                class="col-span-9 mr-10"
            >
                <div x-show="currentTab === 'calendar'">
                    <livewire:social::components.team-calendar
                        before-calendar-view="calendar-views.header"
                        event-view="calendar-views.event-item"
                    />
                </div>    
                <div x-show="currentTab === 'map'">
                    <x-library::map.google class="h-screen" :places="$places"/>
                </div>
            </div>
        </div>
    </div>
@endsection
