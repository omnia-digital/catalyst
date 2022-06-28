@extends('social::livewire.layouts.main-layout')

@section('content')
    <div class="space-y-8">
        <x-library::heading.2 boldClass="font-bold">Discover</x-library::heading.2>

        <div>
            <x-library::heading.3 class="uppercase">Featured & Recommended</x-library::heading.3>

            {{--      Use $featuredTeams      --}}
        </div>

        <div>
            <x-library::heading.3 class="uppercase">Find Projects</x-library::heading.3>
            <div class="bg-white flex justify-between items-center mt-2 px-4 py-3">
                <div class="flex items-center space-x-4">
                    <x-heroicon-o-calendar class="w-5 h-5"/>
                    <div class="flex items-center space-x-1">
                        <x-heroicon-o-filter class="w-5 h-5"/>
                        <p>Filter (2)</p>
                    </div>
                </div>
                <p>
                    <a href="{{ route('projects.home') }}" class="font-bold">View All Projects</a>
                </p>
            </div>
            <x-library::map.google class="h-96" :places="$places"/>
        </div>

        <div>
            <x-library::heading.3 class="uppercase">Trending</x-library::heading.3>

            {{--      Use $trendingTeams      --}}
        </div>

        <div>
            <div class="flex items-center space-x-2">
                <x-library::heading.3 class="uppercase">Categories ({{ count($categories) }})</x-library::heading.3>
                <a href="#" class="text-gray-500 text-xs">View All</a>
            </div>

            <div class="flex justify-between px-8 py-4">
                @foreach ($categories as $category)
                    <x-library::button.link :href="route('projects.home', ['lens' => str($category)->slug()->value()])">
                        {{ $category }}
                    </x-library::button.link>
                @endforeach
            </div>
        </div>

        <div>
            <div class="flex items-center space-x-2">
                <x-library::heading.3 class="uppercase">Curated</x-library::heading.3>
                <a href="{{ route('projects.home', ['filters[tags][0]' => 'curated']) }}" class="text-gray-500 text-xs">View All</a>
            </div>

            <div class="px-4 sm:px-6 md:px-0">
                <div class="py-4">
                    <div class="col-span-2 grid grid-cols-5 gap-3">
                        @foreach($curatedTeams as $team)
                            <x-teams.card :team="$team"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center space-x-2">
                <x-library::heading.3 class="uppercase">Popular Indies</x-library::heading.3>
                <a href="{{ route('projects.home', ['lens' => 'popular-indies']) }}" class="text-gray-500 text-xs">View All</a>
            </div>

            <div class="px-4 sm:px-6 md:px-0">
                <div class="py-4">
                    <div class="col-span-2 grid grid-cols-5 gap-3">
                        @foreach($popularIndiesTeams as $team)
                            <x-teams.card :team="$team"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center space-x-2">
                <x-library::heading.3 class="uppercase">Popular Upcoming</x-library::heading.3>
                <a href="{{ route('projects.home', ['lens' => 'popular-upcoming']) }}" class="text-gray-500 text-xs">View All</a>
            </div>

            <div class="px-4 sm:px-6 md:px-0">
                <div class="py-4">
                    <div class="col-span-2 grid grid-cols-5 gap-3">
                        @foreach($popularIndiesTeams as $team)
                            <x-teams.card :team="$team"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection