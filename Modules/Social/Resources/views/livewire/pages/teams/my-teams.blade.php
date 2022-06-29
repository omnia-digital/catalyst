@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div>
        <div class="">
            <div class="">
                <div class="mb-2 flex justify-between items-center">
                    <div class="flex-1 flex items-center">
                        <h1 class="py-2 text-3xl">{{ Trans::get('My Teams') }}</h1>
                        <span class="bg-gray-400 text-xs rounded-full ml-2 w-5 h-5 flex items-center justify-center">{{ $teamsCount }}</span>
                    </div>

                    <x-library::button x-data="" x-on:click.prevent="$openModal('create-team')" class="py-2 w-60 h-10">
                        {{ Trans::get('Create Team') }}
                    </x-library::button>
                </div>
            </div>

            <!-- Filters -->
            @include('livewire.partials.filters')

            <!-- Initiatives -->
            <div class="mt-6">
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-3 mt-4">
                    @forelse ($teams as $team)
                        <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                    @empty
                        <p class="p-4 bg-primary rounded-md text-base-text-color">{{ Trans::get('No Teams Found') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
        <livewire:create-team-modal/>
    </div>
@endsection
