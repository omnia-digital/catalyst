<div>
    <div class="mb-6 border-t border-b border-gray-100 sm:flex sm:items-center sm:justify-between">
        <div class="flex items-center pr-8">
            <span class="mr-3">Sort:</span>
            {{-- <x-library::input.select 
                :options="['title', 'bookmarks', 'likes', 'user', 'date']" 
                class="border-transparent shadow-none mt-0 pr-3" 
            /> --}}
            <x-library::dropdown.index>
                <x-slot:trigger class=" hover:cursor-pointer text-base-text-color hover:text-black">{{ $sortLabels[$orderBy] }}</x-slot>
                @foreach ($sortLabels as $key => $item)
                    <x-library::dropdown.item class="hover:bg-gray-300" wire:click.prevent="sortBy('{{ $key }}')">{{ $item }}</x-library::dropdown.item>
                @endforeach
            </x-library::dropdown.index>
            @if (!$sortDesc)
                <x-heroicon-o-arrow-narrow-up class="w-4 ml-2 hover:cursor-pointer text-dark-text-color" wire:click.prevent="$toggle('sortDesc')" />
            @else
                <x-heroicon-o-arrow-narrow-down class="w-4 ml-2 hover:cursor-pointer text-dark-text-color" wire:click.prevent="$toggle('sortDesc')" />
            @endif
        </div>
        <div class="flex-1 min-w-0 bg-primary p-2 rounded-lg">
            <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
                <div class="w-full relative">
                    <x-library::input.text type="search" wire:model.debounce.500ms="search" placeholder="Search..." class="px-4 py-2 pl-8 bg-neutral border-1 border-secondary"/>
                    <div class="absolute top-0 flex items-center h-full ml-3">
                        <svg class="w-4 text-dark-text-color" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-primary px-6 rounded-lg mb-6 border-t border-b border-gray-100 py-2 sm:flex sm:items-center sm:justify-between">
        <div class="font-bold">
            {{-- <x-input.select wire:model="filters.speaker" :options="$speakers" placeholder="All Speakers" enableDefaultOption/> --}}
            Filters
        </div>
        <div class="w-full relative md:w-1/3">
            <x-library::input.date wire:model="filters.created_at" class="pl-8" placeholder="Select Date"/>
            <div class="absolute top-0 flex items-center h-full ml-3">
                <x-heroicon-o-calendar class="w-4 text-dark-text-color" />
            </div>
            <div class="absolute top-0 right-0 flex items-center h-full mr-3">
                <x-heroicon-o-chevron-down class="w-4 text-dark-text-color" />
            </div>
        </div>
        <div class="w-full md:w-1/2 flex items-center justify-end space-x-2">
            <x-library::input.toggle wire:model="filters.has_attachment"/>
            <div class="text-sm text-base-text-color">Has Attachment</div>
        </div>
    </div>
</div>
