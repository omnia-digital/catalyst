@extends('social::livewire.layouts.pages.team-calendar-layout')

@section('content')
    <div class="mt-6">
        <!-- Calendar -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-3">
                <livewire:social::components.team-calendar-list />
            </div>
            <div class="col-span-9 mr-10">
                <livewire:social::components.team-calendar
                    before-calendar-view="calendar-views.header"
                    event-view="calendar-views.event-item"
                />
            </div>
        </div>
    </div>
@endsection
