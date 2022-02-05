<div>
    <div class="max-w-7xl mx-auto bg-neutral">
        <div class="flex-1 flex justify-between items-center">
            <h1 class="py-4 ml-4 text-3xl">Community</h1>
            <div class="ml-4 flex items-center md:ml-6">
                <button type="button" class="p-1 mx-1 rounded-full text-gray-400 hover:text-primary focus:outline-none">
                    <span class="sr-only">View notifications</span>
                    <x-heroicon-o-bookmark />
                </button>
                <button type="button" class="p-1 mr-2 rounded-full text-gray-400 hover:text-primary focus:outline-none">
                    <span class="sr-only">View notifications</span>
                    <x-heroicon-o-bell />
                </button>
                <!-- Profile dropdown -->
{{--                <Menu as="div" class="ml-3 relative">--}}
{{--                    <div>--}}
{{--                        <MenuButton--}}
{{--                            class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary hover:ring-2 hover:ring-offset-2 hover:ring-primary">--}}
{{--                            <span class="sr-only">Open user menu</span>--}}
{{--                            <img class="h-12 w-12 rounded-full"--}}
{{--                                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"--}}
{{--                                    alt=""/>--}}
{{--                        </MenuButton>--}}
{{--                    </div>--}}
{{--                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"--}}
{{--                                leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">--}}
{{--                        <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">--}}
{{--                            <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">--}}
{{--                                <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">--}}
{{--                                    {{ $item->name }}--}}
{{--                                </a>--}}
{{--                            </MenuItem>--}}
{{--                        </MenuItems>--}}
{{--                    </transition>--}}
{{--                </Menu>--}}
            </div>
        </div>
    </div>

        <div class="min-h-screen bg-gray-100 px-4 sm:px-0">
            <div as="nav" class="max-w-7xl mx-auto border-b border-neutral">
                <div>
                    <div class="flex h-16 justify-between">
                        <div class="-ml-2 mr-2 flex items-center md:hidden">
                            <!-- Mobile menu button -->
                            <x-jet-button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Open main menu</span>
                                <x-heroicon-o-menu v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                                <x-heroicon-o-x v-else class="block h-6 w-6" aria-hidden="true"/>
                            </x-jet-button>
                        </div>
                        <div class="hidden md:flex md:items-center space-x-8">
                            <jet-nav-link v-for="item in navigation" :key="item.name" :href="route(item.name)" :active="route().current(item.name)">
{{--                                <component :is="item.icon" class="mr-3 flex-shrink-0 h-6 w-6" aria-hidden="true"/>--}}
{{--                                {{ $item->label }}--}}
                            </jet-nav-link>
                        </div>
                        <div class="flex justify-center px-2 lg:ml-6 lg:justify-end items-center">
                            <div class="max-w-lg w-full lg:max-w-xs">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-heroicon-o-search class="h-5 w-5 dark:text-gray-400" aria-hidden="true" />
                                    </div>
                                    <input id="search" name="search"
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 dark:bg-gray-700 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-white focus:ring-white focus:text-gray-900 sm:text-sm"
                                            placeholder="Search" type="search"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="md:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
{{--                        @foreach($navigation as $item)--}}
{{--                            <x-jet-button as="a" href="{{$item->href}}"--}}
{{--                                                class="[{{$item->current}} ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base--}}
{{--                                                font-medium']"--}}
{{--                                             aria-current="{{$item->current}} ? 'page' : ''">--}}
{{--                                   {{ $item->name }}--}}
{{--                            </x-jet-button>--}}
{{--                        @endforeach--}}
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-700">
                        <div class="flex items-center px-5 sm:px-6">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" :src="user?.imageUrl" alt=""/>
                            </div>
                            <div class="ml-3">
{{--                                <div class="text-base font-medium text-white">{{ $user?->name }}</div>--}}
{{--                                <div class="text-sm font-medium text-gray-400">{{ $user?->email }}</div>--}}
                            </div>
                            <button type="button"
                                    class="ml-auto flex-shrink-0 bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <x-heroicon-o-bell class="h-6 w-6" aria-hidden="true"/>
                            </button>
                        </div>
                        <div class="mt-3 px-2 space-y-1 sm:px-3">
{{--                            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"--}}
{{--                                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">--}}
{{--                                {{ $item->name }}--}}
{{--                            </DisclosureButton>--}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
</div>

