<div class="relative w-full" x-data="{ isVisible: true }" @click.away="isVisible = false">
    <input
        wire:model.debounce.300ms="search"
        type="text"
        x-ref="search"
        class="w-full pl-16 pr-3 py-4 border border-neutral bg-white rounded-md leading-6 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none
        focus:ring-dark-text-color sm:text-2xl"
        @keydown.window="
            if (event.keyCode === 191) {
                event.preventDefault();
                $refs.search.focus();
            }
        "
        @focus="isVisible = true"
        @keydown.escape.window = "isVisible = false"
        @keydown="isVisible = true"
        @keydown.shift.tab="isVisible = false"
    >
    <div class="absolute top-0 flex items-center h-full ml-6">
        <svg class="fill-current text-gray-400 w-6" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0
        000 12z"/></svg>
    </div>

    <div wire:loading class="top-0 right-0 text-lg items-center absolute mr-4 mt-4"><i class="fa-duotone fa-loader animate-spin"></i> Loading...</div>

    @if (strlen($search) >= 2)
        <div class="absolute z-30 bg-white text-md text- rounded-lg shadow mt-2" x-show.transition.opacity.duration.200="isVisible">

            @if (count($searchResults) > 0)
                <ul>
                    @foreach ($searchResults as $game)
                        <li class="">
                            <a
                                href="{{ route('games.games.show', $game->details['slug']) }}"
                                class="block hover:bg-primary hover:text-white-text-color flex items-center transition ease-in-out duration-150 px-3 py-3"
                                @if ($loop->last) @keydown.tab="isVisible=false" @endif
                            >
                                @if (!empty($game->details?->getCoverUrl()))
                                    <img src="{{ $game->details?->getCoverUrl() }}" alt="cover" class="w-10">
                                @else
                                    <img src="https://via.placeholder.com/264x352" alt="game cover" class="w-10">
                                @endif
                                <span class="ml-4">{{ $game->details['name'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">No results for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>
