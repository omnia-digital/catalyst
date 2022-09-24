@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg px-4 pl-4 flex items-center bg-secondary">
        <div class="flex-1 flex items-center">
            <x-dynamic-component component="heroicon-o-briefcase"
                                 class="{{ 'text-primary' }} mr-3 flex-shrink-0 h-8 w-8"
                                 aria-hidden="true"/>
            <x-library::heading.1 class="py-4 text-3xl hover:cursor-pointer" text-color="text-white-text-color">{{ Trans::get('Teams') }}</x-library::heading.1>
            <span class="bg-gray-400 text-xs rounded-full ml-2 w-5 h-5 flex items-center justify-center">{{ $teamsCount }}</span>
        </div>
        @can('create', \Team::class)
            <x-library::button x-data="" x-on:click.prevent="$openModal('create-team')" class="hidden sm:block bg-primary text-base-text-color py-2 w-60 h-10 mr-6">
                {{ Trans::get('Create Team') }}
            </x-library::button>
        @endcan
        <x-dynamic-component component="heroicon-o-plus-circle"
                             class="{{ 'text-primary' }} sm:hidden flex-shrink-0 h-8 w-8"
                             aria-hidden="true"
                             x-data=""
                             x-on:click.prevent="$openModal('create-team')"
        />
    </div>
    <div>
        <!-- Filters -->
        @include('livewire.partials.filters', ['skipFilters' => ['has_attachment', 'members']])

        <!-- Teams -->
        <div class="mt-2">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-0 lg:grid-cols-4">
                @forelse ($teams as $team)
                    <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                @empty
                    <p class="p-4 bg-primary rounded-md text-base-text-color">{{ Trans::get('No Teams Found') }}</p>
                @endforelse
            </div>
        </div>
        <livewire:create-team-modal/>
    </div>
@endsection
