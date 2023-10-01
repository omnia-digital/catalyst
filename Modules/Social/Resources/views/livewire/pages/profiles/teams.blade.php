@extends('social::livewire.layouts.pages.user-profile-layout')

@section('content')
    <x-profiles.partials.header :user="$this->user"/>
    <div class="mt-4">
        <x-library::heading.2
                class="text-base-text-color font-semibold text-2xl">{{ Platform::getTeamsWordUpper() }}</x-library::heading.2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 mr-4">
            @forelse ($teams as $team)
                <livewire:social::components.teams.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
            @empty
                <p class="p-4 bg-secondary rounded-md text-base-text-color">{{ Trans::get('No teams to show') }}</p>
            @endforelse
        </div>
    </div>
@endsection
