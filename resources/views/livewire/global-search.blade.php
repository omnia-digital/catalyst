<div class="hidden sm:flex w-full items-center">
    <div
            x-data="{
                show: false,
                search: @entangle('search')
            }"
            x-init="() => {
                $watch('search', value => {
                    if (value.length > 0) {
                        show = true;
                    }
                })
            }"
            class="w-full"
    >
        <label for="search" class="sr-only">{{ Trans::get('Search ' . config('app.name')) }}</label>
        <div class="relative w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-heroicon-o-search class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
            </div>
            <input x-model.debounce.500ms="search"
                   id="search" name="search"
                   class="block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm"
                   placeholder="{{ Trans::get('Search ' . config('app.name')) }}" type="search"/>

            @if ($searchResults && !empty($search))
                <ul x-show="show" x-on:click.away="show = false" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
                    @forelse($searchResults->groupByType() as $type => $modelSearchResults)
                        @foreach($modelSearchResults as $searchResult)
                            <li wire:key="{{ $type }} - {{ uniqid() }}" class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" id="option-0" role="option" tabindex="-1">
                                <a href="{{ $searchResult->url }}">
                                    <span class="block truncate">{{ $searchResult->title }}</span>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                            {{ $searchResult->type }}
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @empty
                        <li class="p-2">No results for "{{ $search }}"</li>
                    @endforelse
                </ul>
            @endif
        </div>
    </div>
</div>
