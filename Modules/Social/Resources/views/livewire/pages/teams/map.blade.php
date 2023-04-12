@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="pr-4">
        <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
            <div class="flex-1 flex items-center">
                <x-library::icons.icon name="fa-regular fa-map" color="text-secondary" class="h-8 w-8 mr-3"/>
                <x-library::heading.1 class="py-4">Map</x-library::heading.1>
            </div>
        </div>
        <livewire:social::components.teams.map/>
    </div>
@endsection
