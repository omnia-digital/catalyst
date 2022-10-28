@php
    $skipFilters = isset($skipFilters) ? $skipFilters : [];
@endphp
<div class="h-10 px-4 text-sm bg-neutral flex items-center justify-between">
    <div class="flex items-center pr-3">
        <x-library::dropdown.index :position="'left'" class="z-10 py-2 rounded-md bg-neutral" :dropdownClasses="'bg-primary border-none shadow-md'">
            <x-slot:trigger class=" hover:cursor-pointer text-base-text-color hover:text-secondary">
                <span class="mr-3 font-bold">Sort: </span>
                {{ $sortLabels[$orderBy] }}
                <i class="fa-solid fa-caret-down ml-1"></i>
            </x-slot>
            @foreach ($sortLabels as $key => $item)
                <x-library::dropdown.item class="bg-primary border-none" wire:click.prevent="sortBy('{{ $key }}')">{{ $item }}</x-library::dropdown.item>
            @endforeach
        </x-library::dropdown.index>
        @if ($sortOrder === 'asc')
            <x-heroicon-o-arrow-narrow-up class="w-4 ml-2 hover:cursor-pointer text-base-text-color hover:text-secondary" wire:click.prevent="toggleSortOrder()" />
        @else
            <x-heroicon-o-arrow-narrow-down class="w-4 ml-2 hover:cursor-pointer text-base-text-color hover:text-secondary" wire:click.prevent="toggleSortOrder()" />
        @endif
    </div>
    <div class="flex items-center">
        <x-library::dropdown.index :position="'right'" class="z-10 py-2 rounded-md bg-neutral" :dropdownClasses="'bg-primary border-none shadow-md sm:w-48'">
            <x-slot:trigger class="flex items-center hover:cursor-pointer text-base-text-color hover:text-secondary">
                <x-heroicon-o-filter class="w-4 h-4" /><span class="ml-2 font-semibold">Filter {{ $filterCount ? "({$filterCount})" : '' }}</span>
            </x-slot>
            @unless(in_array('date', $skipFilters))
                <x-library::dropdown.item class="bg-primary relative border-none">
                    <x-library::input.date wire:model="dateFilter" class="pl-8 text-xs" placeholder="Launch Date"/>
                    <div class="absolute top-0 flex items-center h-full ml-3">
                        <x-heroicon-o-calendar class="w-4 text-dark-text-color" />
                    </div>
                    <div class="absolute top-0 right-2 flex items-center h-full mr-3">
                        <x-heroicon-o-chevron-down class="w-4 text-dark-text-color" />
                    </div>
                </x-library::dropdown.item>
            @endunless
            @unless(in_array('has_attachment', $skipFilters))
                <x-library::dropdown.item class="bg-primary border-none flex items-center">
                    <x-library::input.toggle wire:model="filters.has_attachment"/>
                    <div class="text-xs text-base-text-color ml-2">Has Media</div>
                </x-library::dropdown.item>
            @endunless
        </x-library::dropdown.index>
    </div>
</div>