<div x-data="{ open: false }" class="{{ $class }} block sm:hidden">
    <div class="fixed bottom-0 bg-white z-[999] w-full px-4">
        <div class="flex justify-around">
            @foreach (collect($navigation)->take(4) as $item)
                <a href="{{ route($item['name']) }}"
                   class="{{ request()->routeIs($item['name']) ? 'text-secondary' : 'text-light-text-color hover:text-white-text-color' }} {{
                               'group text-center
                               text-base-text-color py-3' }}">
                    <div class="text-xs font-medium text-center py-0 leading-2">
                        <x-dynamic-component :component="$item['icon']"
                                             class="{{ request()->routeIs($item['name']) ? 'text-secondary' : 'text-light-text-color group-hover:text-light-text-color' }} flex-shrink-0 h-8 w-8
                                             inline text-center" aria-hidden="true"/>
                        <br/>
                        <span class="{{ request()->routeIs($item['name']) ? 'text-secondary' : 'text-light-text-color group-hover:text-light-text-color' }} text-center inline"
                        >{{ $item['label'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{--    <!-- mobile slideout sidebar -->--}}
    {{--    <div--}}
    {{--            x-show="open" @click.away="open = false"--}}
    {{--            x-transition:enter.duration.100ms--}}
    {{--            x-transition:leave.duration.75ms--}}
    {{--    >--}}
    {{--        <div class="sticky inset-0 flex z-40 md:hidden">--}}
    {{--            <div aria-hidden="true" class="sticky inset-0 bg-neutral bg-opacity-75"></div>--}}
    {{--            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-neutral-dark">--}}
    {{--                <div class="absolute top-0 right-0 -mr-12 pt-2">--}}
    {{--                    <button type="button"--}}
    {{--                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"--}}
    {{--                            tabindex="0"--}}
    {{--                            @click="open = false"--}}
    {{--                    >--}}
    {{--                        <span class="sr-only">Close sidebar</span>--}}
    {{--                        <x-heroicon-o-x class="h-6 w-6 text-white-text-color"/>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="flex-shrink-0 flex items-center px-4">--}}
    {{--                    <!-- mobile logo -->--}}
    {{--                    <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-secondary.svg" alt="Indie Game Dev logo">--}}
    {{--                    <p class="text-green-500 text-3xl font-bold">{{ config('app.abbr') }}</p>--}}
    {{--                </div>--}}
    {{--                <div class="mt-5 flex-1 h-0 overflow-y-auto">--}}
    {{--                    <!-- mobile nav -->--}}
    {{--                    <nav class="px-2 space-y-1">--}}
    {{--                        <a href="#" class="bg-neutral text-base-text-color group flex items-center px-2 py-2 text-sm font-medium rounded-md" aria-current="page">--}}
    {{--                            <!----}}
    {{--                              Heroicon name: outline/home--}}

    {{--                              Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"--}}
    {{--                            -->--}}
    {{--                            <svg class="text-light-text-color mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
    {{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
    {{--                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>--}}
    {{--                            </svg>--}}
    {{--                            Home--}}
    {{--                        </a>--}}
    {{--                        @foreach ($navigation as $item)--}}
    {{--                            <a href="{{ route($item['name']) }}"--}}
    {{--                               class="{{ request()->routeIs($item['name']) ? 'bg-neutral-dark text-white-text-color' : 'text-light-text-color hover:bg-neutral-hover hover:text-white-text-color' }} {{--}}
    {{--                               'group--}}
    {{--                               flex items-center--}}
    {{--                               px-2 py-2 text-base-text-color font-medium' }}">--}}
    {{--                                <x-library::heading.2>--}}
    {{--                                    <x-dynamic-component :component="$item['icon']"--}}
    {{--                                                         class="{{ $item['current'] ? 'text-white-text-color' : 'text-light-text-color group-hover:text-light-text-color' }} mr-3 flex-shrink-0 h-6 w-6"--}}
    {{--                                                         aria-hidden="true"/>--}}
    {{--                                    <span>{{ $item['label'] }}</span>--}}
    {{--                                </x-library::heading.2>--}}
    {{--                            </a>--}}
    {{--                        @endforeach--}}
    {{--                    </nav>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="flex-shrink-0 w-14" aria-hidden="true">--}}
    {{--                <!-- Dummy element to force sidebar to shrink to fit close icon -->--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <!-- Header -->--}}
    {{--    <div class="md:pl-24 flex flex-col md:hidden">--}}
    {{--        <div class="flex-shrink-0 flex h-16 bg-primary shadow">--}}
    {{--            <!-- mobile menu button -->--}}
    {{--            <button--}}
    {{--                    type="button"--}}
    {{--                    class="px-4 border-r border-neutral-light text-base-text-color focus:outline-none focus:ring-2 focus:ring-inset focus:ring-secondary md:hidden"--}}
    {{--                    @click="open = true"--}}
    {{--            >--}}
    {{--                <span class="sr-only">Open sidebar</span>--}}
    {{--                <x-heroicon-o-menu class="h-6 w-6"/>--}}
    {{--            </button>--}}
    {{--            <!-- Sub-App header -->--}}
    {{--            <slot name="header"></slot>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>
