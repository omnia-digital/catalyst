<div class="border-t border-b border-gray-100 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
    <div class="flex-1 min-w-0">
        <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
            <div class="w-full md:w-2/3 relative">
                <x-input.text type="search" wire:model.debounce.500ms="search" placeholder="Find people"
                              class="px-4 py-2 pl-8"/>
                <div class="absolute top-0 flex itmes-center h-full ml-2">
                    <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
