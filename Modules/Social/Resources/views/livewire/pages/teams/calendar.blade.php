@extends('social::livewire.layouts.pages.full-page-layout')
@section('content')
        <div class="pr-4">
            <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center bg-primary items-center">
                <div class="flex-1 flex items-center">
                    <x-library::icons.icon name="fa-regular fa-calendar" color="text-secondary" class="h-8 w-8 mr-3"/>
                    <x-library::heading.1 class="py-4">Calendar</x-library::heading.1>
                </div>
            </div>
        <div x-data="{openMobileTeams: false}" class="sm:h-full-minus-[56px] relative">
            <div :class="openMobileTeams ? 'z-10 left-0 top-0 bg-neutral' : 'left-[-395px]'" class="h-full absolute sm:block sm:z-0 sm:static transition-all delay-75 duration-300">
                <livewire:social::components.team-calendar-list :events="\App\Models\Team::first()" />
            </div>
            <div class="flex sm:hidden justify-center items-center fixed bottom-4 right-4 z-20 bg-transparent p-px w-12 h-12">
                <button
                    x-on:click="openMobileTeams = !openMobileTeams"
                    class="flex justify-center items-center p-3 text-sm rounded-full bg-primary border border-secondary text-secondary hover:bg-neutral-light active:bg-neutral-light focus:bg-neutral-light">
                    <x-heroicon-o-collection class="w-4 h-4" />
                </button>
            </div>
        </div>
        <livewire:social::components.teams.team-calendar/>
    </div>
@endsection
