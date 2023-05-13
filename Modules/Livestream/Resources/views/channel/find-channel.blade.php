<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if ($channels->count())
            <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Search result for "{{ $search }}".
                </h3>
{{--                <div class="mt-3 sm:mt-0 sm:ml-4">--}}
{{--                    <label for="search-candidate" class="sr-only">Search</label>--}}
{{--                    <div class="flex rounded-md shadow-sm">--}}
{{--                        <button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">--}}
{{--                            <!-- Heroicon name: solid/sort-ascending -->--}}
{{--                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                <path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"/>--}}
{{--                            </svg>--}}
{{--                            <span class="ml-2">Sort</span>--}}
{{--                            <!-- Heroicon name: solid/chevron-down -->--}}
{{--                            <svg class="ml-2.5 -mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>--}}
{{--                            </svg>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <ul class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($channels as $channel)
                    <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200">
                        <div class="flex-1 flex flex-col p-8">
                            <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full"
                                 src="{{ $channel->livestreamAccount->team->photoUrl }}" alt="{{ $channel->name }}">
                            <h3 class="mt-6 text-gray-900 text-sm font-medium">{{ $channel->name }}</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
{{--                                <dt class="sr-only">Title</dt>--}}
{{--                                <dd class="text-gray-500 text-sm">Paradigm Representative</dd>--}}
                                <dt class="sr-only">Team</dt>
                                <dd class="mt-3">
                                    <span class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">
                                        {{ $channel->livestreamAccount->team->name }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="w-0 flex-1 flex">
                                    <a href="{{ route('channels.show', $channel) }}" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                                        <x-heroicon-o-eye class="w-5 h-5 text-gray-400"/>
                                        <span class="ml-3">View Channel</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="my-10">
                {{ $channels->onEachSide(1)->links() }}
            </div>
        @elseif (!$search)
            <h2 class="text-gray-500 text-2xl text-center font-medium">Please enter a keyword to find channel.</h2>
        @else
            <div class="text-center">
                <x-heroicon-o-emoji-sad class="w-12 h-12 text-gray-400 mx-auto mb-6"/>
                <h2 class="text-gray-500 text-2xl font-medium">No channel matched the given criteria.</h2>
            </div>
        @endif
    </div>
</div>
