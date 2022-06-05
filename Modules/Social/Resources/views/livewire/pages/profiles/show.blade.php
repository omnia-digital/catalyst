@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="flex space-x-4">
    <div class="mx-auto max-w-3xl">
        <div class="-ml-4">
            <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat relative overlay before:bg-black before:inset-0 before:opacity-60">
                <div class="mb-1 mx-[15px] absolute bottom-0 left-0 right-0 flex justify-between items-end">
                    <div class="flex items-end">
                        <div class="mr-3 z-10 -mb-12">
                            <img class="h-24 w-24 rounded-full" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" />
                        </div>
                        <div>
                            <h1 class="text-3xl text-white">{{ $this->user->name  }}</h1>
                            <p class="text-sm text-white">{{ '@' .  $this->user->handle }}</p>
                        </div>
                    </div>
                    <div class="flex items-center text-white text-3xl font-semibold">
                        <x-heroicon-s-star class="w-6 h-6" />
                        {{ $this->user->reviewScore ?? '3758' }}
                    </div>
                </div>
            </div>
            <x-profiles.overview-navigation class="bg-gray-300" :user="$this->user" />
        </div>
        <div class="flex space-x-6 mt-4 -ml-4">
            <div class="space-y-4">
                <div class="p-[15px] rounded bg-primary space-y-3 text-base-text-color">
                    <div class="flex justify-start text-sm space-x-4">
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-location-marker class="w-4 h-4" />
                            <span>{{ $profile->country }}</span>
                        </div>
                        @isset ($profile->website)
                            <div class="flex items-center space-x-2">
                                <x-heroicon-o-link class="w-4 h-4" />
                                <span>{{ $profile->website }}</span>
                            </div>
                        @endisset
                        <div class="flex items-center space-x-2">
                            <x-heroicon-o-calendar class="w-4 h-4" />
                            <span>{{ $this->user->created_at->toFormattedDateString() }}</span>
                        </div>
                    </div>
                    <div>{{ $this->user->profile->bio }}</div>
                </div>

                <!-- Profile Awards -->
                <div>
                    <div>
                        <div class="flex justify-between items-center text-black font-semibold">
                            <p class="text-sm">Awards</p>
                            <a href="#" class="text-xs flex items-center">See all <x-heroicon-s-chevron-right class="ml-2 w-4 h-4" /></a>
                        </div>
                        <div class="mt-2 flex space-x-2">
                            <div class="bg-white p-2 flex-1 flex items-center">
                                <div class="rounded-full bg-gray-500 mr-4 p-2">
                                    <x-heroicon-s-academic-cap class="w-4 h-4" />
                                </div>
                                <p class="whitespace-nowrap">Gold user</p>
                            </div>
                            <div class="bg-white p-2 flex-1 flex items-center">
                                <div class="rounded-full bg-gray-500 mr-4 p-2">
                                    <x-heroicon-s-academic-cap class="w-4 h-4" />
                                </div>
                                <p class="whitespace-nowrap">Gold user</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Reviews -->
                <div>
                    <div class="flex justify-between items-center text-black font-semibold">
                        <p class="text-sm">Reviews</p>
                        <a href="#" class="text-xs flex items-center">See all <x-heroicon-s-chevron-right class="ml-2 w-4 h-4" /></a>
                    </div>
                    <div class="flex justify-start items-start mt-2 bg-primary border border-neutral-light p-4">
                        <div class="mr-2">
                            <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                        </div>
                        <div class="flex-1 space-y-2">
                            <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                            <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                        </div>
                        <div class="flex text-light-text-color">
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                            <x-heroicon-s-star class="h-5 w-5" />
                        </div>
                    </div>
                </div>

                <!-- User Posts -->
                <div>
                    <div class="flex justify-between items-center text-black font-semibold">
                        <p class="text-sm flex">Timeline <span class="bg-gray-400 rounded-full ml-2 w-5 h-5 flex justify-center items-center">{{ $this->user->posts()->count() }}</span></p>
                        <a href="#" class="text-xs flex items-center">See all <x-heroicon-s-chevron-right class="ml-2 w-4 h-4" /></a>
                    </div>
                    <div class="mt-2 space-y-2">
                        @foreach ($this->user->posts as $post)
                            <livewire:social::components.post-card :post="$post" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-sidebar-column class="max-w-sm"/>
</div>
@endsection
