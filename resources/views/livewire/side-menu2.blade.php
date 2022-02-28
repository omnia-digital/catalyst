<div x-data="{ open: false }">
    <!-- mobile slideout sidebar -->
    <div
        x-show="open" @click.away="open = false"
        x-transition:enter.duration.100ms
        x-transition:leave.duration.75ms
    >
        <div class="fixed inset-0 flex z-40 md:hidden">
            <div aria-hidden="true" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button
                        type="button"
                        class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        tabindex="0"
                        @click="open = false"
                    >
                        <span class="sr-only">Close sidebar</span>
                        <x-heroicon-o-x class="h-6 w-6 text-white"/>
                    </button>
                </div>
                <div class="flex-shrink-0 flex items-center px-4">
                    <!-- mobile logo -->
                    <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Indie Game Dev logo">
                    <p class="text-green-500 text-3xl font-bold">IGD</p>
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <!-- mobile nav -->
                    <nav class="px-2 space-y-1">
                        @foreach ($navigation as $item)
                            <a
                                href="{{ route($item['name']) }}"
                                class="{{ request()->routeIs($item['name']) ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} {{ 'group flex items-center px-2 py-2 text-base font-medium rounded-md' }}">
                                <x-dynamic-component :component="$item['icon']" class="{{ $item['current'] ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }} mr-3 flex-shrink-0 h-6 w-6"
                                                        aria-hidden="true"/>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden pt-16 w-24 md:flex md:flex-col md:fixed md:inset-y-0 shadow-lg">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0 ">
            <a href="{{ route('social.home') }}">
                <div class="flex-shrink-0 pl-6 flex p-4">
                    <div class="flex flex-col justify-center items-center">
                        <div>
                            <img class="inline-block h-12 w-12 rounded-full"
                                 src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt=""/>
                        </div>
                        <div class="bg-black flex items-center rounded-md -m-2 p-1">
                            <div class="bg-white text-xxs rounded-md p-1">
                                48
                            </div>
                            <div class="text-xxs text-white p-1">
                                3758
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <div class="flex flex-col divide-y">
                <nav class="py-4 space-y-1">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['name']) }}"
                            title="{{ $item['label'] }}"
                            class="{{ request()->routeIs($item['name']) ? 'bg-gray-200 font-semibold text-black' : 'text-gray-400 hover:text-black hover:bg-gray-200' }}
                            {{ 'w-full py-2 px-6 group flex flex-col justify-center items-center relative text-xs font-medium rounded-md' }}"
                        >
                            <x-dynamic-component
                                :component="$item['icon']"
                                class="flex-shrink-0 h-6 w-6"
                                aria-hidden="true"
                            />
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="md:pl-24 flex flex-col md:hidden">
        <div class="flex-shrink-0 flex h-16 bg-white shadow">
            <!-- mobile menu button -->
            <button
                type="button"
                class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                @click="open = true"
            >
                <span class="sr-only">Open sidebar</span>
                <x-heroicon-o-menu class="h-6 w-6" />
            </button>
            <!-- Sub-App header -->
            <slot name="header"></slot>
        </div>
    </div>
</div>
