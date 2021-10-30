<template>
    <app-layout>
        <div class="min-h-screen bg-gray-100">
            <Disclosure as="nav" class=" border-b border-neutral" v-slot="{ open }">
                <div class="max-w-5xl mx-auto">
                    <div class="flex h-16 justify-between">
                        <div class="-ml-2 mr-2 flex items-center md:hidden">
                            <!-- Mobile menu button -->
                            <DisclosureButton
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Open main menu</span>
                                <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                                <XIcon v-else class="block h-6 w-6" aria-hidden="true"/>
                            </DisclosureButton>
                        </div>
                        <div class="hidden md:flex md:items-center space-x-8">
                            <jet-nav-link v-for="item in navigation" :key="item.name" :href="route(item.name)" :active="route().current(item.name)">
                                <component :is="item.icon" class="mr-3 flex-shrink-0 h-6 w-6" aria-hidden="true"/> {{ item.label }}
                            </jet-nav-link>
                        </div>
                        <div class="flex justify-center px-2 lg:ml-6 lg:justify-end items-center">
                            <div class="max-w-lg w-full lg:max-w-xs">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <SearchIcon class="h-5 w-5 dark:text-gray-400" aria-hidden="true"/>
                                    </div>
                                    <input id="search" name="search"
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 dark:bg-gray-700 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-white focus:ring-white focus:text-gray-900 sm:text-sm"
                                           placeholder="Search" type="search"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <DisclosurePanel class="md:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                                          :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']"
                                          :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                        </DisclosureButton>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-700">
                        <div class="flex items-center px-5 sm:px-6">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt=""/>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-white">{{ user.name }}</div>
                                <div class="text-sm font-medium text-gray-400">{{ user.email }}</div>
                            </div>
                            <button type="button"
                                    class="ml-auto flex-shrink-0 bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">View notifications</span>
                                <BellIcon class="h-6 w-6" aria-hidden="true"/>
                            </button>
                        </div>
                        <div class="mt-3 px-2 space-y-1 sm:px-3">
                            <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href"
                                              class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.name }}
                            </DisclosureButton>
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>

            <!-- Page content -->
            <slot></slot>
        </div>
    </app-layout>
</template>

<script>
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel,} from '@headlessui/vue'
import {AcademicCapIcon, BellIcon, HomeIcon, MenuIcon, HashtagIcon, UserGroupIcon, OfficeBuildingIcon, UserIcon, XIcon} from '@heroicons/vue/outline'
import {PlusSmIcon, SearchIcon} from '@heroicons/vue/solid'
import AppLayout from "@/Layouts/AppLayout";
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

// const navigation = [
//     {label: 'Home', name: 'home', icon: HomeIcon, current: true},
//     {label: 'Messages', name: 'messages', icon: UsersIcon, current: false},
//     {label: 'Learn', name: 'learn', icon: AcademicCapIcon, current: false},
//     {label: 'Marketplace', name: 'marketplace', icon: OfficeBuildingIcon, current: false},
// ]
const navigation = [
    {label: 'Home', name: 'home', icon: HomeIcon, current: true},
    {label: 'Explore', name: 'explore', icon: HashtagIcon, current: false},
    {label: 'Profile', name: 'profile', icon: UserIcon, current: false},
    {label: 'Projects', name: 'projects', icon: OfficeBuildingIcon, current: false},
    {label: 'Groups', name: 'groups', icon: UserGroupIcon, current: false},
]
const userNavigation = [
    {name: 'Your Profile', href: '#'},
    {name: 'Settings', href: '#'},
    {name: 'Sign out', href: '#'},
]

const user = {
    name: 'Chelsea Hagon',
    handle: 'chelseahagon',
    email: 'chelseahagon@example.com',
    role: 'Human Resources Manager',
    imageId: '1550525811-e5869dd03032',
    imageUrl:
        'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}

export default {
    components: {
        AppLayout,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        PlusSmIcon,
        Menu,
        UserIcon,
        MenuButton,
        MenuItem,
        MenuItems,
        HomeIcon,
        HashtagIcon,
        UserGroupIcon,
        Head,
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
        Popover,
        PopoverButton,
        PopoverPanel,
        BellIcon,
        MenuIcon,
        SearchIcon,
        XIcon,
    },
    setup() {
        return {
            user,
            navigation,
            userNavigation,
        }
    },

}
</script>
