@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
    <div class="space-y-8">
        <h1 class="py-2 text-3xl">{{ \Trans::get('Discover New Teams') }}</h1>

        <div>
            <x-library::heading.3 class="uppercase">{{ \Trans::get('Featured & Recommended') }}</x-library::heading.3>

            {{--      Use $featuredTeams      --}}
        </div>

{{--        <div>--}}
{{--            <livewire:social::components.find-projects/>--}}
{{--        </div>--}}

        <div>
            <x-library::heading.3 class="uppercase">{{ \Trans::get('Find Teams') }}</x-library::heading.3>

            <livewire:social::pages.teams.map/>
        </div>

        <div>
            @if($trendingTeams->count())
                <div class="flex items-center space-x-2">
                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Trending') }}</x-library::heading.3>
                </div>
                <div class="px-4 sm:px-6 md:px-0">
                    <div class="py-4">
                        <div class="col-span-2 grid grid-cols-5 gap-3">
                            @foreach($trendingTeams as $team)
                                <livewire:social::components.team-card :team="$team" wire:key="trending-team-{{ $team->id }}"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            @if(count($categories))
                <div class="flex items-center space-x-2">
                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Categories') }} ({{ count($categories) }})</x-library::heading.3>
                    <a href="#" class="text-gray-500 text-xs"></a>
                </div>

                <div class="flex justify-between space-x-2 py-4">
                    @foreach ($categories as $category)
                        <x-library::button.link :href="route('social.teams.home', ['lens' => str($category)->slug()->value()])" class="w-full h-16 text-base-text-color">
                            {{ $category }}
                        </x-library::button.link>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            @if($curatedTeams->count())
                <div class="flex items-center space-x-2">
                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Curated') }}</x-library::heading.3>
                    <a href="{{ route('social.teams.home', ['tags[0]' => 'curated']) }}" class="text-gray-500 text-xs">View All</a>
                </div>

                <div class="px-4 sm:px-6 md:px-0">
                    <div class="py-4">
                        <div class="col-span-2 grid grid-cols-4 gap-3">
                            @foreach($curatedTeams->take(4) as $team)
                                <livewire:social::components.team-card :team="$team" wire:key="curated-team-{{ $team->id }}"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{--        <div>--}}
        {{--            <div class="flex items-center space-x-2">--}}
        {{--                <x-library::heading.3 class="uppercase">{{ \Trans::get('Popular Indies') }}</x-library::heading.3>--}}
        {{--                <a href="{{ route('social.teams.home', ['lens' => 'popular-indies']) }}" class="text-gray-500 text-xs">View All</a>--}}
        {{--            </div>--}}

        {{--            <div class="px-4 sm:px-6 md:px-0">--}}
        {{--                <div class="py-4">--}}
        {{--                    <div class="col-span-2 grid grid-cols-5 gap-3">--}}
        {{--                        @foreach($popularIndiesTeams as $team)--}}
        {{--                            <x-teams.card :team="$team"/>--}}
        {{--                        @endforeach--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div>
            @if($popularIndiesTeams->count())
                <div class="flex items-center space-x-2">
                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Popular Upcoming') }}</x-library::heading.3>
                    <a href="{{ route('social.teams.home', ['lens' => 'popular-upcoming']) }}" class="text-gray-500 text-xs">{{ \Trans::get('View All') }}</a>
                </div>

                <div class="px-4 sm:px-6 md:px-0">
                    <div class="py-4">
                        <div class="col-span-2 grid grid-cols-5 gap-3">
                            @foreach($popularIndiesTeams as $team)
                                <livewire:social::components.team-card :team="$team" wire:key="popular-indies-team-{{ $team->id }}"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
