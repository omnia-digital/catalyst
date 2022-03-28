<div class="bg-primary px-2 rounded-lg mb-6 border-t border-b border-gray-100 py-2 sm:flex sm:items-center sm:justify-between">
    <div class="flex-1 min-w-0">
        <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
            <div class="w-full relative">
                <x-library::input.text type="search" wire:model.debounce.500ms="search" placeholder="Search..." class="px-4 py-2 pl-8 bg-neutral border-1 border-secondary"/>
                <div class="absolute top-0 flex items-center h-full ml-3">
                    <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
{{--            <div class="w-full md:w-1/4">--}}
{{--                <x-input.select wire:model="filters.speaker" :options="$speakers" placeholder="All Speakers" enableDefaultOption/>--}}
{{--            </div>--}}
{{--            <div class="w-full md:w-1/4">--}}
{{--                <x-library::input.date wire:model="filters.date_created" placeholder="Created Date"/>--}}
{{--            </div>--}}
{{--            <div class="w-full md:w-1/2 flex items-center justify-end space-x-2">--}}
{{--                <x-library::input.toggle wire:model="filters.has_attachment"/>--}}
{{--                <div class="text-sm text-gray-600">Has Attachment</div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
