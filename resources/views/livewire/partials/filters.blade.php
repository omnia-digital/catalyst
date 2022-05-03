<div>
    <div class="bg-primary px-2 rounded-lg mb-6 border-t border-b border-gray-100 py-2 sm:flex sm:items-center sm:justify-between">
        <div class="flex-1 min-w-0">
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
        <div class="font-bold">Sort</div>
        <x-sort-button key="title" :orderBy="$orderBy" :sortDesc="$sortDesc">Title</x-sort-button>
        <x-sort-button key="bookmarks_count" :orderBy="$orderBy" :sortDesc="$sortDesc">Bookmarks</x-sort-button>
        <x-sort-button key="likes_count" :orderBy="$orderBy" :sortDesc="$sortDesc">Likes</x-sort-button>
        <x-sort-button key="user_id" :orderBy="$orderBy" :sortDesc="$sortDesc">User</x-sort-button>
        <x-sort-button key="created_at" :orderBy="$orderBy" :sortDesc="$sortDesc">Date</x-sort-button>
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
