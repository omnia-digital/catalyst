<div class="max-w-7xl mx-auto flex flex-col md:px-8 xl:px-0 pt-20">
    <main class="flex-1">
        <div class="py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Projects
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <x-library::button x-data="" x-on:click.prevent="$openModal('create-team')">
                        Create Project
                    </x-library::button>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <p class="font-bold">Sort</p>
                    <x-library::dropdown>
                        <x-slot name="trigger" class="flex items-center cursor-pointer text-gray-600">
                            <span class="text-sm">By {{ $sortField }}</span>

                            @if ($sortDirection === 'asc')
                                <x-heroicon-s-arrow-down class="w-4 h-4 ml-1"/>
                            @else
                                <x-heroicon-s-arrow-up class="w-4 h-4 ml-1"/>
                            @endif
                        </x-slot>

                        <x-library::dropdown.item wire:click.prevent="sortBy('name')">By name</x-library::dropdown.item>
                        <x-library::dropdown.item wire:click.prevent="sortBy('members')">By members</x-library::dropdown.item>
                        {{--                        <x-library::dropdown.item wire:click.prevent="sortBy('rating')">By rating</x-library::dropdown.item>--}}
                    </x-library::dropdown>
                </div>
                <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
                    <div class="flex items-center px-6 py-4 md:max-w-3xl md:mx-auto lg:max-w-none lg:mx-0 xl:px-0">
                        <div class="w-full">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <x-heroicon-s-search class="h-5 w-5 text-gray-400"/>
                                </div>
                                <input wire:model.debounce.400ms="filters.search" id="search" name="search" class="block w-full bg-white border border-gray-300 rounded-md py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:outline-none focus:text-gray-900 focus:placeholder-gray-400 focus:ring-1 focus:ring-neutral-dark focus:border-neutral-dark sm:text-sm" placeholder="Search" type="search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 bg-white shadow-sm rounded-md flex items-center space-x-4 px-4 py-2">
                <x-library::heading.3>Filters</x-library::heading.3>

                <div>
                    <x-library::input.text wire:model.debounce.450ms="filters.location" placeholder="Location"/>
                </div>

                <div>
                    <x-library::input.date wire:model="filters.start_date" placeholder="Select Date"/>
                </div>

                <div class="flex items-center w-full z-50">
                    <x-library::input.label value="Members" class="mr-8 font-bold"/>
                    <x-library::input.range-slider
                            wire:model.defer="filters.members"
                            :min="0" :max="100" :step="5" :decimals="0"/>
                </div>

                {{--                    <div>--}}
                {{--                        <div class="mt-2 grid grid-cols-3 gap-3 sm:grid-cols-5">--}}
                {{--                            @for($i = 1; $i <= 5; $i++)--}}
                {{--                                <x-library::input.checkbox-card wire:model="filters.rating" wire:key="rating-{{ $i }}" :value="$i">--}}
                {{--                                    <div class="flex items-center space-x-1">--}}
                {{--                                        <span>{{ $i }}</span>--}}
                {{--                                        <x-heroicon-o-star class="w-4 h-4"/>--}}
                {{--                                    </div>--}}
                {{--                                </x-library::input.checkbox-card>--}}
                {{--                            @endfor--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
            </div>

            <div class="px-4 sm:px-6 md:px-0">
                <div class="py-4">
                    <div class="col-span-2 grid grid-cols-3 gap-3">
                        @foreach($projects as $project)
                            <div>
                                <a href="#" class="block rounded-lg shadow-sm bg-white">
                                    <img
                                            alt="{{ $project->name }}"
                                            src="https://images.unsplash.com/photo-1554995207-c18c203602cb"
                                            class="object-cover w-full h-56 rounded-t-md"
                                    />

                                    <div class="mt-2">
                                        <div class="flex items-center justify-between px-2">
                                            <div class="font-medium">
                                                {{ $project->name }}
                                            </div>

                                            <div class="sm:inline-flex sm:items-center sm:shrink-0">
                                                <x-heroicon-o-user-group class="w-4 h-4 text-indigo-700"/>

                                                <div class="sm:ml-3 mt-1.5 sm:mt-0">

                                                    <div class="font-medium">
                                                        {{ $project->members }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-sm text-gray-500 flex items-center p-2">
                                            <x-heroicon-o-location-marker class="w-4 h-4 mr-2"/>
                                                <span>{{ $project->teamLocation?->name ?? 'Not set' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>

    <livewire:create-team-modal/>
</div>
