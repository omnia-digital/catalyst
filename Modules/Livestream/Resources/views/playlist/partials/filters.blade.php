<div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
    <div class="flex-1 min-w-0">
        <div
            x-data="{
                search: null,

                speaker: '',

                series: '',

                topics: '',

                updateQueryStringParameter(key, value) {
                    const url = new URL(window.location.href);

                    url.searchParams.set(key, value === null ? '' : value);
                    history.pushState(null, document.title, url.toString());
                },

                removeQueryStringParameter(key) {
                    const url = new URL(window.location.href);

                    url.searchParams.delete(key);
                    history.pushState(null, document.title, url);
                },

                searchEpisodes() {
                    
                    let queryParams = {};

                    if (!!this.search) {
                        this.updateQueryStringParameter('search', this.search);
                        queryParams.search = this.search;
                    } else {
                        this.removeQueryStringParameter('search');
                        delete queryParams.search;
                    }

                    if (!!this.speaker) {
                        this.updateQueryStringParameter('speaker', this.speaker);
                        queryParams.speaker = this.speaker;
                    } else {
                        this.removeQueryStringParameter('speaker');
                        delete queryParams.speaker;
                    }
                    
                    if (!!this.series) {
                        this.updateQueryStringParameter('series', this.series);
                        queryParams.series = this.series;
                    } else {
                        this.removeQueryStringParameter('series');
                        delete queryParams.series;
                    }
                    
                    if (!!this.topics) {
                        this.updateQueryStringParameter('topics', this.topics);
                        queryParams.topics = this.topics;
                    } else {
                        this.removeQueryStringParameter('topics');
                        delete queryParams.topics;
                    }
                    
                    omnia.loadPlaylist(queryParams);
                }
            }"
            x-init="() => {
                const urlParams = new URLSearchParams(window.location.search);
                search = urlParams.get('search');
                speaker = urlParams.get('speaker');
                series = urlParams.get('series');
                topics = urlParams.get('topics');
                $refs.searchText.focus();
            }"
            class="filters grid gap-3 md:grid-cols-3"
        >
            <div class="order-first md:col-span-2 relative">
                <x-input.text
                    x-model="search"
                    x-on:keyup.enter.stop="searchEpisodes()"
                    x-ref="searchText"
                    type="search"
                    placeholder="Search" class="px-4 py-2 pl-8"/>
                <div class="absolute top-0 flex items-center h-full ml-2">
                    <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="order-last md:order-2 md:col-span-1">
                <button 
                    x-on:click="searchEpisodes()" 
                    class="leading-6 inline-flex justify-center w-full shadow-sm bg-gold rounded-md py-2 px-4 text-sm font-weight-500 line-height-15 font-Montserrat text-white font-style-normal hover:bg-yellow-600 hover:text-white focus:outline-none focus:shadow-outline focus:bg-yellow-600">
                    <span>Search</span>
                </button>
            </div>
            <div class="order-3 md:col-span-1">
                <select x-model="speaker" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm border-gray-300 rounded-md">
                    <option value="">All Speakers</option>
                    @foreach ($speakers as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="order-4 md:col-span-1">
                <select x-model="series" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm border-gray-300 rounded-md">
                    <option value="">All Series</option>
                    @foreach ($series as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="order-5 md:col-span-1 flex items-center space-x-2">
                <select x-model="topics" class="block focus:ring-blue-500 focus:border-blue-500 w-full shadow-sm border-gray-300 rounded-md">
                    <option value="">All Topics</option>
                    @foreach ($topics as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
