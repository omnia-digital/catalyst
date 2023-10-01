@extends('games::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="container mx-auto px-4">
        <x-library::heading.2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games
        </x-library::heading.2>
        {{--                <livewire:games::components.popular-games/>--}}

        <div class="grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4">
            @foreach ($games as $game)
                <livewire:games::components.game-card :game="$game"/>
            @endforeach
        </div> <!-- end container -->
@endsection
