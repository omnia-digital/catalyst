<x-app-layout>
    <main class="w-full xl:w-1/2 mx-auto pb-10 lg:py-12 lg:px-8 px-4">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                <nav class="space-y-1">
                    <a href="{{ route('settings.video') }}" class="{{ request()->routeIs('settings.video') ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                        <x-heroicon-o-video-camera class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                        <span class="truncate">Video</span>
                    </a>

                    @if (\Auth::user()->isAdmin())
                        <a href="{{ route('settings.streaming') }}" class="{{ request()->routeIs('settings.streaming') ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                            <x-heroicon-o-video-camera class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                            <span class="truncate">Streaming</span>
                        </a>
                    @endif

                    <a href="{{ route('settings.player') }}" class="{{ request()->routeIs('settings.player') ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                        <x-heroicon-o-play class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                        <span class="truncate">Player</span>
                    </a>

                    <a href="{{ route('settings.episode') }}" class="{{ request()->routeIs('settings.episode') ? 'bg-gray-50 text-indigo-600 hover:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50' }} group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                        <x-heroicon-o-photograph class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                        <span class="truncate">Episodes</span>
                    </a>
                </nav>
            </aside>

            <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                {{ $slot }}
            </div>
        </div>
    </main>
</x-app-layout>
