<div x-data="{ open: false }" class="{{ $class }}">
    <!-- mobile slideout sidebar -->
    <div
            x-show="open" @click.away="open = false"
            x-transition:enter.duration.100ms
            x-transition:leave.duration.75ms
    >
        <div class="sticky inset-0 flex z-40 md:hidden">
            <div aria-hidden="true" class="sticky inset-0 bg-gray-600 bg-opacity-75"></div>
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button type="button"
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
                    <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-secondary.svg" alt="Indie Game Dev logo">
                    <p class="text-green-500 text-3xl font-bold">{{ config('app.abbr') }}</p>
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <!-- mobile nav -->
                    <nav class="px-2 space-y-1">
                        <a href="#" class="bg-gray-200 text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md" aria-current="page">
                            <!--
                              Heroicon name: outline/home

                              Current: "text-gray-500", Default: "text-gray-400 group-hover:text-gray-500"
                            -->
                            <svg class="text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Home
                        </a>
                        @foreach ($navigation as $item)
                            <a href="{{ route($item['name']) }}"
                               class="{{ request()->routeIs($item['name']) ? 'bg-gray-900 text-white' : 'text-light-text-color hover:bg-gray-700 hover:text-white' }} {{ 'group flex items-center
                               px-2 py-2 text-base-text-color font-medium' }}">
                                <h2>
                                    <x-dynamic-component :component="$item['icon']"
                                                         class="{{ $item['current'] ? 'text-white' : 'text-light-text-color group-hover:text-light-text-color' }} mr-3 flex-shrink-0 h-6 w-6"
                                                         aria-hidden="true"/>
                                    <span>{{ $item['label'] }}</span>
                                </h2>
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
    <div class="hidden md:flex md:flex-col md:sticky md:inset-y-0">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex flex-col min-h-0 ">
            <div class="flex">
                <nav class="space-y-3">
                    @foreach ($navigation as $item)
                        <a href="{{ route($item['name']) }}"
                           title="{{ $item['label'] }}"
                           class="{{ request()->routeIs($item['name']) ? 'bg-neutral-light font-semibold text-black' : 'text-light-text-color hover:text-black hover:bg-neutral-light' }}
                           {{ 'w-full py-2 group flex justify-left items-center text-xl space-x-2 font-medium' }}"
                           aria-current="page">
                            <x-dynamic-component
                                    :component="$item['icon']"
                                    class="flex-shrink-0 h-6 w-6"
                                    aria-hidden="true"
                            />
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
            <livewire:partials.profile-badge/>
        </div>
    </div>

    <!-- Header -->
    <div class="md:pl-24 flex flex-col md:hidden">
        <div class="flex-shrink-0 flex h-16 bg-primary shadow">
            <!-- mobile menu button -->
            <button
                    type="button"
                    class="px-4 border-r border-neutral-light text-base-text-color focus:outline-none focus:ring-2 focus:ring-inset focus:ring-secondary md:hidden"
                    @click="open = true"
            >
                <span class="sr-only">Open sidebar</span>
                <x-heroicon-o-menu class="h-6 w-6"/>
            </button>
            <!-- Sub-App header -->
            <slot name="header"></slot>
        </div>
    </div>
</div>
