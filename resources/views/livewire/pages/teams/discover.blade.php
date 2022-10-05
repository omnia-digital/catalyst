@extends('social::livewire.layouts.pages.full-page-layout')

@section('full-width-header')
    <div class="w-full mb-4">
        <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
            <div class="absolute inset-0 grayscale">
                <img class="h-full w-full object-cover"
                     src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                     alt="People working on laptops">
                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                <x-library::heading.1 class="text-center uppercase" text-size="text-5xl">
                    {{ Trans::get('DISCOVER') }}
                </x-library::heading.1>
                <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">{{ Trans::get('Find Teams and other resources') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mt-6 space-y-8">
        {{-- Featured Teams --}}
        <div>
            <x-library::heading.3 class="uppercase">{{ \Trans::get('Featured Teams') }}</x-library::heading.3>
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
                @forelse ($featuredTeams->take(4) as $team)
                    <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                @empty
                    <p class="p-4 bg-primary rounded-md text-base-text-color">{{ Trans::get('No Featured Teams Found') }}</p>
                @endforelse
            </div>
        </div>

        {{-- New Teams --}}
        <div>
            <x-library::heading.3 class="uppercase">{{ \Trans::get('New Teams') }}</x-library::heading.3>
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4">
                @forelse ($newTeams->take(4) as $team)
                    <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                @empty
                    <p class="p-4 bg-primary rounded-md text-base-text-color">{{ Trans::get('No New Teams Found') }}</p>
                @endforelse
            </div>
        </div>

        @if(\Platform::isModuleEnabled('games'))
            {{--            <h2>Recommended YouTube Channels</h2>--}}
            {{--            <div class="space-y-6">--}}
            {{--                @foreach($youtubeFeeds as $youtubeFeed)--}}
            {{--                    <livewire:games::components.feed-section :feed-url="$youtubeFeed" type="youtube"/>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}

            {{--            <h2>Recommended Twitch Channels</h2>--}}
            {{--            <div class="space-y-6">--}}
            {{--                @foreach($twitchFeeds as $youtubeFeed)--}}
            {{--                    <livewire:games::components.feed-section :feed-url="$youtubeFeed" type="youtube"/>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
        @endif

        <div>
            <x-library::heading.3 class="uppercase">{{ \Trans::get('Team Map') }}</x-library::heading.3>
            <livewire:social::pages.teams.map class=""/>
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

        @if(count($categories))
            <div>
                <div class="flex items-center space-x-2">
                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Categories') }} ({{ count($categories) }})</x-library::heading.3>
                    <a href="{{ route('social.teams.home') }}" class="text-gray-500 text-xs">{{ Trans::get('View All Teams') }}</a>
                </div>

                <div class="flex justify-between space-x-2 py-4">
                    @foreach ($categories as $category)
                        <x-library::button.link :href="route('social.teams.home', ['lens' => $category['slug']])" class="w-full h-16 text-base-text-color">
                            {{ $category['name'] }}
                        </x-library::button.link>
                    @endforeach
                </div>
            </div>

            @foreach($categories as $category)
                <div>
                    <div class="flex items-center space-x-2">
                        <x-library::heading.3 class="uppercase">{{ \Trans::get($category['name']) }}</x-library::heading.3>
                        <a href="{{ route('social.teams.home', ['tags[0]' => $category['slug']]) }}" class="text-gray-500 text-xs">View All</a>
                    </div>

                    <div class="px-4 sm:px-6 md:px-0">
                        <div class="py-4">
                            <div class="col-span-2 grid grid-cols-4 gap-3">
                                @foreach($this->getTeams($category['slug'])->take(4) as $team)
                                    <livewire:social::components.team-card :team="$team" wire:key="curated-team-{{ $team->id }}"/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
{{--        <div>--}}
{{--            @if($curatedTeams->count())--}}
{{--                <div class="flex items-center space-x-2">--}}
{{--                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Curated') }}</x-library::heading.3>--}}
{{--                    <a href="{{ route('social.teams.home', ['tags[0]' => 'curated']) }}" class="text-gray-500 text-xs">View All</a>--}}
{{--                </div>--}}

{{--                <div class="px-4 sm:px-6 md:px-0">--}}
{{--                    <div class="py-4">--}}
{{--                        <div class="col-span-2 grid grid-cols-4 gap-3">--}}
{{--                            @foreach($curatedTeams->take(4) as $team)--}}
{{--                                <livewire:social::components.team-card :team="$team" wire:key="curated-team-{{ $team->id }}"/>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

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

{{--        <div>--}}
{{--            @if($popularIndiesTeams->count())--}}
{{--                <div class="flex items-center space-x-2">--}}
{{--                    <x-library::heading.3 class="uppercase">{{ \Trans::get('Popular Upcoming') }}</x-library::heading.3>--}}
{{--                    <a href="{{ route('social.teams.home', ['lens' => 'popular-upcoming']) }}" class="text-gray-500 text-xs">{{ \Trans::get('View All') }}</a>--}}
{{--                </div>--}}

{{--                <div class="px-4 sm:px-6 md:px-0">--}}
{{--                    <div class="py-4">--}}
{{--                        <div class="col-span-2 grid grid-cols-5 gap-3">--}}
{{--                            @foreach($popularIndiesTeams as $team)--}}
{{--                                <livewire:social::components.team-card :team="$team" wire:key="popular-indies-team-{{ $team->id }}"/>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
    </div>
@endsection
