<div class="max-w-7xl mx-auto flex flex-col md:px-8 xl:px-0 pt-20">
    <main class="flex-1">
        <div class="py-6">
            <div class="px-4 sm:px-6 md:px-0">
                <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
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
                        <x-library::dropdown.item wire:click.prevent="sortBy('location')">By location</x-library::dropdown.item>
                        <x-library::dropdown.item wire:click.prevent="sortBy('members')">By members</x-library::dropdown.item>
                        <x-library::dropdown.item wire:click.prevent="sortBy('rating')">By rating</x-library::dropdown.item>
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
            <div class="px-4 sm:px-6 md:px-0">
                <div class="grid grid-cols-3 gap-4 py-4">
                    <div class="border border-gray-200 bg-white shadow-sm rounded-md p-4 min-h-screen">
                        <x-library::heading.3>Filters</x-library::heading.3>

                        <div class="py-4 space-y-4">
                            <div>
                                <x-library::input.label>Location</x-library::input.label>
                                <x-library::input.text wire:model.defer="filters.location" placeholder="Location"/>
                            </div>

                            <div>
                                <x-library::input.label>Date</x-library::input.label>
                                <x-library::input.date wire:model.defer="filters.date" placeholder="Select Date"/>
                            </div>

                            <div>
                                <x-library::input.label>Number of Members</x-library::input.label>
                                <x-library::input.range-slider
                                        wire:model.defer="filters.members"
                                        :min="0" :max="100" :step="5" :decimals="0"
                                        showTextFields/>
                            </div>

                            <div>
                                <x-library::input.label>Rating</x-library::input.label>
                                <x-library::input.range-slider
                                        wire:model.defer="filters.rating"
                                        :min="1" :max="5" :step="1" :decimals="0" :options="['tooltips' => true]"/>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-library::button class="w-full" wire:click="filter" wire:target="filter">
                                Show
                            </x-library::button>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div>
                            @foreach($projects as $project)
                                <div>
                                    {{ $project->name }} - {{ $project->location }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
