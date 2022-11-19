@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="sticky top-[55px] z-40 mb-4 rounded-b-lg px-4 pl-4 flex items-center bg-primary">
        <div class="flex-1 flex items-center space-x-2 -ml-1">
            <x-library::icons.icon name="fa-regular fa-users" size="w-8 h-8" color="text-white-text-color"/>
            <x-library::heading.1 class="py-4 text-3xl hover:cursor-pointer" text-color="text-white-text-color">{{ Trans::get('Teams') }}</x-library::heading.1>
            <span class="bg-gray-400 text-xs rounded-full ml-2 w-5 h-5 flex items-center justify-center">{{ $teamsCount }}</span>
        </div>
        @can('create', \App\Models\Team::class)
            <x-library::button.index x-data=""
                                     x-on:click.prevent="$openModal('create-team')"
                                     bg-color="primary"
                                     text-color="text-primary"
                                     size="w-60 h-10" py="py-2 "
                                     class="hidden sm:block">
                {{ Trans::get('Create Team') }}
            </x-library::button.index>
        @endcan
    </div>
    <div class="px-4 sm:px-2 lg:px-0">
        <!-- Filters -->
        @include('livewire.partials.filters', ['skipFilters' => ['has_attachment', 'members']])

        <!-- Teams -->
        <div class="mt-2">
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
                @forelse ($teams as $team)
                    <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                @empty
                    <p class="p-4 bg-secondary rounded-md text-base-text-color">{{ Trans::get('No Teams Found') }}</p>
                @endforelse
            </div>
        </div>
        <livewire:create-team-modal/>
    </div>

    {{-- Create Team button --}}
    @can('create', \App\Models\Team::class)
        <div class="sm:hidden fixed bottom-16 right-4 h-16 mb-2 w-16 z-[999]">
            <button class="float-right p-3 bg-primary rounded-full"
                    x-data=""
                    x-on:click.prevent="$openModal('create-team')">
                <x-library::icons.icon name="heroicon-o-plus" color="text-secondary"/>
                {{--            <x-library::heading.2>Create</x-library::heading.2>--}}
            </button>
        </div>
    @endcan
@endsection
