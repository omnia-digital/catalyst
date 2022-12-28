@extends('social::livewire.layouts.pages.user-profile-layout')

@section('content')
    <x-profiles.partials.header :user="$this->user"/>
    <div class="mt-6 grid grid-cols-6 xl:grid-cols-12 gap-6 px-4 lg:px-0">
        <div class="col-span-6 md:col-span-3 xl:col-span-3 space-y-4">
            <div class="p-4 rounded bg-secondary text-base-text-color">
                <div class="flex justify-start text-sm space-x-4">
                    @isset ($profile->website)
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-link class="w-4 h-4"/>
                            <span>{{ $profile->website }}</span>
                        </div>
                    @endisset
                </div>
                <div>{{ $this->user->profile->bio }}</div>
            </div>

            <!-- Profile Awards -->
            <div class="block">
                <div class="flex justify-between items-center text-base-text-color font-semibold">
                    <p class="text-sm">{{ \Trans::get('Awards') }}</p>
                    @if($this->user->awards()->count())
                        <a href="{{ route('social.profile.awards', $profile) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}
                            <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                        </a>
                    @endif
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($this->user->awards()->take(4)->get() as $award)
                        <x-awards-banner class="flex-1" :award="$award"/>
                    @empty
                        <div class="bg-white p-4 flex-1">
                            <p class="text-dark-text-color">{{ \Trans::get('No awards to show.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Skills --}}
{{--            <div class="hidden sm:block">--}}
{{--                <div class="flex justify-between items-center text-base-text-color font-semibold">--}}
{{--                    <p class="text-sm">{{ \Trans::get('Skills') }}</p>--}}
{{--                    @if($this->user->awards()->count())--}}
{{--                        <a href="{{ route('social.profile.awards', $profile) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}--}}
{{--                            <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="mt-4 space-y-4">--}}
{{--                    @forelse ($this->user->awards()->take(4)->get() as $award)--}}
{{--                        <x-awards-banner class="flex-1" :award="$award"/>--}}
{{--                    @empty--}}
{{--                        <div class="bg-white p-4 flex-1">--}}
{{--                            <p class="text-dark-text-color">{{ \Trans::get('No awards to show.') }}</p>--}}
{{--                        </div>--}}
{{--                    @endforelse--}}
{{--                </div>--}}
{{--            </div>--}}

            {{-- Teams --}}
            <div class="block xl:hidden">
                <div class="flex justify-between items-center text-base-text-color font-semibold">
                    <p class="text-sm">{{ \Platform::getTeamsWord() }}</p>
                    @if($this->user->teams()->count())
                        <a href="{{ route('social.profile.teams', $profile) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}
                            <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                        </a>
                    @endif
                </div>
                <div class="mt-4 flex space-x-2">
                    @if($this->user->teams()->count())
                        <div class="w-full grid {{ $this->user->teams()->count() > 1 ? 'grid-cols-2' : '' }} gap-2">
                            @foreach ($this->user->teams->take(2) as $team)
                                <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white p-4 flex-1">
                            <p class="text-dark-text-color">{{ \Trans::get('No teams to show.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Reviews -->
            {{-- <div class="hidden sm:block xl:hidden">
                <div class="flex justify-between items-center text-base-text-color font-semibold">
                    <p class="text-sm">Reviews</p>
                    <a href="#" class="text-xs flex items-center">See all
                        <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                    </a>
                </div>
                <div class="flex justify-start items-start mt-2 bg-secondary border border-neutral-light p-4">
                    <div class="mr-4">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy"/>
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                        <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                    </div>
                    <div class="flex text-light-text-color">
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                    </div>
                </div>
            </div> --}}

        </div>
        <div class="block col-span-6 md:col-span-3 xl:col-span-5 lg:mr-4 xl:mr-0">
            <!-- User Posts -->
            <x-social::user-posts
                :posts="$this->user->posts()->onlyPosts()->get()"
                :likes="$this->user->likes"
                :resources="$this->user->posts()->onlyResources()->get()"
            />
        </div>
        <div class="hidden xl:block col-span-4 space-y-4 xl:mr-4">
            {{-- Teams --}}
            <div>
                <div class="flex justify-between items-center text-base-text-color font-semibold">
                    <p class="text-sm">{{ \Platform::getTeamsWord() }}</p>
                    @if($this->user->teams()->count())
                        <a href="{{ route('social.profile.teams', $profile) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}
                            <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                        </a>
                    @endif
                </div>
                <div class="mt-4 flex space-x-2">
                    @if($this->user->teams()->count())
                        <div class="w-full grid {{ $this->user->teams()->count() > 1 ? 'grid-cols-2' : '' }} gap-2">
                            @foreach ($this->user->teams->take(2) as $team)
                                <livewire:social::components.team-card :team="$team" wire:key="team-{{ $team->id }}"/>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white p-4 flex-1">
                            <p class="text-dark-text-color">{{ \Trans::get('No teams to show.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Reviews -->
            {{-- <div>
                <div class="flex justify-between items-center text-base-text-color font-semibold">
                    <p class="text-sm">Reviews</p>
                    <a href="#" class="text-xs flex items-center">See all
                        <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                    </a>
                </div>
                <div class="flex justify-start items-start mt-2 bg-secondary border border-neutral-light p-4">
                    <div class="mr-4">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy"/>
                    </div>
                    <div class="flex-1 space-y-2">
                        <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                        <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                    </div>
                    <div class="flex text-light-text-color">
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                        <x-heroicon-s-star class="h-5 w-5"/>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection
