<div>
    <!-- mobile slideout sidebar -->
    @if ($isOpen)
        <div>
            <div class="fixed inset-0 flex z-40 md:hidden">
                <div aria-hidden="true" class="fixed inset-0 bg-neutral-dark bg-opacity-75"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-dark-text-color">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                            tabindex="0"
                            wire:click="closeMobileMenu"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <x-heroicon-o-x class="text-primary"/>
                        </button>
                    </div>
                    <div class="flex-shrink-0 flex items-center px-4">
                        <!-- mobile logo -->
                        <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-secondary.svg" alt="Indie Game Dev logo">
                        <p class="text-green-500 text-3xl font-bold">IGD</p>
                    </div>
                    <div class="mt-5 flex-1 h-0 overflow-y-auto">
                        <!-- mobile nav -->
                        <nav class="px-2 space-y-1">
                            @foreach ($navigation as $item)
                                <a
                                    href="{{ route($item['name']) }}"
                                    class="{{ request()->routeIs($item['name']) ? 'bg-secondary text-primary' : 'text-light-text-color hover:bg-neutral-dark hover:text-primary' }} {{ 'group flex items-center px-2 py-2 text-base-text-color font-medium rounded-md' }}">
                                    <x-dynamic-component :component="$item['icon']" class="{{ $item['current'] ? 'text-primary' : 'text-light-text-color group-hover:text-light-text-color' }} mr-3 flex-shrink-0 h-6 w-6"
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
    @endif

<!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 shadow-lg">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex-1 flex flex-col min-h-0 bg-secondary">
            <div class="flex items-center pl-6 h-16 flex-shrink-0">
                <!-- desktop logo -->
                <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-secondary.svg" alt="Workflow">
                <p class="text-green-500 text-3xl font-bold">IGD</p>
            </div>
            <a href="{{ route('social.home') }}">
                <div class="flex-shrink-0 pl-6 flex p-4">
                    <div class="flex items-center">
                        <div>
                            <img class="inline-block h-12 w-12 rounded-full"
                                 src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                 alt=""/>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-primary">
                                Joshua Torres
                            </p>
                            <p class="text-base-text-color font-medium text-primary group-hover:text-primary">
                                Lvl 5 <span class="text-gold">5348</span>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 py-4 space-y-1">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['name']) }}"
                            class="{{ request()->routeIs($item['name']) ? 'bg-tertiary text-primary' : 'text-light-text-color hover:bg-tertiary hover:text-primary' }} {{ 'w-full pl-6 group flex items-center
                            px-2 py-2
                            text-lg font-medium rounded-md' }}">
                            <x-dynamic-component :component="$item['icon']" class="{{ $item['current'] ? 'text-primary' : 'text-light-text-color group-hover:text-light-text-color' }} mr-3 flex-shrink-0 h-6 w-6"
                                                 aria-hidden="true"/>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    {{-- <Link v-for="item in navigation" :key="item.name" :href="route(item.name)"
                          :class="[$page.component === '' ? 'bg-tertiary text-primary' :
                    'text-light-text-color hover:bg-tertiary hover:text-primary',
                    'group flex items-center px-2 py-2 text-lg font-medium rounded-md']">
                        <component :is="item.icon" :class="[item.current ? 'text-primary' : 'text-light-text-color group-hover:text-light-text-color', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true"/>
                        {{ item.label }}
                    </Link> --}}
                </nav>
            </div>
        </div>
    </div>
</div>
