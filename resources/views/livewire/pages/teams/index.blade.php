<div class="max-w-7xl mx-auto flex flex-col md:px-8 xl:px-0 ">
    <main class="flex-1">
        <div class="py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ $lens ? str($lens)->headline() : 'All Projects' }}
                    </h2>
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
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-search class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
                                </div>
                                <input wire:model.debounce.400ms="filters.search" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm" placeholder="Search" type="search">
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
                    <x-library::input.date wire:model="filters.start_date" placeholder="Project Launch Date"/>
                </div>

                <div class="w-96">
                    <x-library::input.selects wire:model="filters.tags" :options="$tags"/>
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
                        @foreach($teams as $team)
                            <x-teams.card :team="$team"/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
