<x-library::input.text type="search" wire:model.live.debounce.500ms="search" :placeholder="$placeholder"
                       class="px-4 block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm"/>
