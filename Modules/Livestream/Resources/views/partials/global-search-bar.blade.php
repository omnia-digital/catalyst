<form
    x-data="{
        search: '{{ request('search') }}',
        route: '{{ route('channels.find') }}',
        action: null,
        blacklistTags: ['INPUT', 'TEXTAREA']
    }"
    x-init="$watch('search', value => action = route + '?search=' + value)"
    x-on:keyup.enter="window.location.replace(action);"
    x-on:keydown.window="
        if ($event.keyCode === 191 && !blacklistTags.includes($event.target.tagName)) {
            $event.preventDefault();
            $refs['searchInput'].focus();
        }
    "
    class="w-full flex md:ml-0"
    action="" method="GET"
>
    <label for="search_field" class="sr-only">Search for a channel</label>
    <div class="relative w-full text-gray-400 focus-within:text-gray-600">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">
            <x-heroicon-s-search class="flex-shrink-0 h-5 w-5"/>
        </div>
        <input x-model="search" x-ref="searchInput" name="search" id="search_field" class="h-full w-full border-transparent py-2 pl-8 pr-3 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent focus:placeholder-gray-400 sm:hidden" placeholder="Find channel" type="search">
        <input x-model="search" x-ref="searchInput" name="search" id="search_field" class="hidden h-full w-full border-transparent py-2 pl-8 pr-3 text-base text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0 focus:border-transparent focus:placeholder-gray-400 sm:block" placeholder="Press / to find channel" type="search">
    </div>
</form>
