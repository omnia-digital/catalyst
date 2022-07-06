@extends('social::livewire.layouts.pages.team-map-calendar-layout')

@section('content')
    <div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-3 h-full-minus-[56px]">
                <livewire:social::components.team-calendar-list/>
            </div>
            <div class="col-span-9 mr-10">
                <x-library::map.mapbox id="project-map" class="h-full-minus-[56px]" :places="$places" mapStyle="mapbox://styles/mapbox/dark-v10"/>
            </div>
        </div>
    </div>
@endsection
