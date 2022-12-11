<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-base-text-color bg-secondary border border-gray-300 cursor-default leading-5 rounded-md">
                        {!! \Trans::get('pagination.previous') !!}
                    </span>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button dusk="previousPage" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-text-color bg-secondary border border-gray-300 leading-5 rounded-md hover:text-base-text-color focus:outline-none focus:shadow-outline-blue focus:border-primary active:bg-neutral active:text-dark-text-color transition ease-in-out duration-150">
                                {!! \Trans::get('pagination.previous') !!}
                        </button>
                    @else
                        <button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-text-color bg-secondary border border-gray-300 leading-5 rounded-md hover:text-base-text-color focus:outline-none focus:shadow-outline-blue focus:border-primary active:bg-neutral active:text-dark-text-color transition ease-in-out duration-150">
                                {!! \Trans::get('pagination.previous') !!}
                        </button>
                    @endif
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button dusk="nextPage" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-dark-text-color bg-secondary border border-gray-300 leading-5 rounded-md hover:text-base-text-color focus:outline-none focus:shadow-outline-blue focus:border-primary active:bg-neutral active:text-dark-text-color transition ease-in-out duration-150">
                                {!! \Trans::get('pagination.next') !!}
                        </button>
                    @else
                        <button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-dark-text-color bg-secondary border border-gray-300 leading-5 rounded-md hover:text-base-text-color focus:outline-none focus:shadow-outline-blue focus:border-primary active:bg-neutral active:text-dark-text-color transition ease-in-out duration-150">
                                {!! \Trans::get('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-base-text-color bg-secondary border border-gray-300 cursor-default leading-5 rounded-md">
                        {!! \Trans::get('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
