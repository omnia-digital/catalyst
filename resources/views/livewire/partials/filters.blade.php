@php
    $skipFilters = isset($skipFilters) ? $skipFilters : [];
@endphp
<div class="space-y-2">
    <div class="bg-secondary px-6 py-2 rounded-lg border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center pr-3">
            <span class="mr-3 font-bold">Sort By</span>
            <x-library::dropdown.index :position="'left'" class="z-10 p-2 rounded-md bg-neutral" :dropdownClasses="'bg-secondary border-none shadow-md'">
                <x-slot:trigger class=" hover:cursor-pointer text-base-text-color hover:text-primary">
                    {{ $sortLabels[$orderBy] }}
                    <i class="fa-solid fa-caret-down ml-1"></i>
                    </x-slot>
                    @foreach ($sortLabels as $key => $item)
                        <x-library::dropdown.item class="bg-secondary border-none" wire:click.prevent="sortBy('{{ $key }}')">{{ $item }}</x-library::dropdown.item>
                @endforeach
            </x-library::dropdown.index>
            @if ($sortOrder === 'asc')
                <x-heroicon-o-arrow-narrow-up class="w-4 ml-2 hover:cursor-pointer text-base-text-color hover:text-primary" wire:click.prevent="toggleSortOrder()"/>
            @else
                <x-heroicon-o-arrow-narrow-down class="w-4 ml-2 hover:cursor-pointer text-base-text-color hover:text-primary" wire:click.prevent="toggleSortOrder()"/>
            @endif
        </div>
        <div class="flex-1 min-w-0 bg-secondary p-2 rounded-lg">
            <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
                <div class="w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-search class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
                    </div>
                    <livewire:partials.search-component/>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between gap-3 flex-wrap bg-secondary px-6 py-2 rounded-lg mb-6 border-t border-b border-gray-100 items-center">
        <div class="flex justify-start items-center space-x-3">
            <div class="font-bold">
                {{ Trans::get('Filters') }}
            </div>
            @unless (in_array('location', $skipFilters))
                <div class="sm:min-w-[110px]">
                    <x-library::input.text wire:model.live.debounce.450ms="filters.location" placeholder="{{ Trans::get('Location') }}"/>
                </div>
            @endunless

            @unless (in_array('date', $skipFilters))
                <div class="sm:min-w-[110px]  relative">
                    <x-library::input.date class="pl-8" wire:model.live="dateFilter"
                                           placeholder="{{ ($this->dateColumn === 'created_at' || $this->dateColumn === 'published_at') ? Trans::get('Date Created') : Trans::get('Launch Date') }}"/>
                    <div class="absolute top-0 flex items-center h-full ml-3">
                        <x-heroicon-o-calendar class="w-4 text-dark-text-color"/>
                    </div>
                </div>
            @endunless

            @unless (in_array('my_teams', $skipFilters))
                @auth
                    <div class="flex items-center space-x-2">
                        <x-library::input.label for="my_teams" color="text-base-text-color">{{ Trans::get('My Teams Only') }}</x-library::input.label>
                        <x-library::input.checkbox wire:model.live="filters.my_teams" name="my_teams"/>
                    </div>
                @endauth
            @endunless
        </div>


        @unless (in_array('tags', $skipFilters))
            <div class="min-w-[135px]">
                <x-library::input.selects wire:model.live="tags" :options="$this->allTags" placeholder="Search by Tags"/>
            </div>
        @endunless

        @unless (in_array('members', $skipFilters))
            <div class="flex items-center w-full mb-2">
                <x-library::input.label value="Members" class="mr-8 text-neutral-dark"/>
                <x-library::input.range-slider
                        wire:model.live="members"
                        :min="0" :max="100" :step="1" :decimals="0"/>
            </div>
        @endunless
        {{-- <div>
            <div class="mt-2 grid grid-cols-3 gap-3 sm:grid-cols-5">
                @for ($i = 1; $i <= 5; $i++)
                    <x-library::input.checkbox-card wire:model.live="filters.rating" wire:key="rating-{{ $i }}" :value="$i">
                        <div class="flex items-center space-x-1">
                            <span>{{ $i }}</span>
                            <x-heroicon-o-star class="w-4 h-4"/>
                        </div>
                    </x-library::input.checkbox-card>
                @endfor
            </div>
        </div> --}}
        @unless (in_array('has_attachment', $skipFilters))
            <div class="w-full py-2 md:w-1/2 flex items-center justify-end space-x-2">
                <x-library::input.toggle wire:model.live="filters.has_attachment"/>
                <div class="text-sm text-base-text-color">Has Media</div>
            </div>
        @endunless
    </div>
    <div></div>
</div>
