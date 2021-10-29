<template>
    <div>
        <!-- mobile slideout sidebar -->
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
                                 leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75"/>
                </TransitionChild>
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0"
                                 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-7" leave-to="-translate-x-full">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                                         leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                        @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                </button>
                            </div>
                        </TransitionChild>
                        <div class="flex-shrink-0 flex items-center px-4">
                            <!-- mobile logo -->
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow"/>
                        </div>
                        <div class="mt-5 flex-1 h-0 overflow-y-auto">
                            <!-- mobile nav -->
                            <nav class="px-2 space-y-1">
                                <a v-for="item in navigation" :key="item.name" :href="item.href"
                                   :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                                    <component :is="item.icon" :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true"/>
                                    {{ item.name }}
                                </a>
                            </nav>
                        </div>
                    </div>
                </TransitionChild>
                <div class="flex-shrink-0 w-14" aria-hidden="true">
                    <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 shadow-lg">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0 bg-secondary">
                <div class="flex items-center pl-6 h-16 flex-shrink-0">
                    <!-- desktop logo -->
                    <img class="h-8 mr-2 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                    <p class="text-green-500 text-3xl font-bold">IGD</p>
                </div>
                <a :href="route('profile')">
                    <div class="flex-shrink-0 pl-6 flex p-4 bg-tertiary">
                        <div class="flex items-center">
                            <div>
                                <img class="inline-block h-12 w-12 rounded-full"
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                     alt=""/>
                            </div>
                            <div class="ml-3">
                                <p class="text-lg font-medium text-white">
                                    Joshua Torres
                                </p>
                                <p class="text-base font-medium text-primary group-hover:text-white">
                                    Lvl 5 <span class="text-gold">5348</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="flex-1 flex pl-6 flex-col overflow-y-auto">
                    <nav class="flex-1 py-4 space-y-1">
                        <a v-for="item in navigation" :key="item.name" :href="route(item.name)" :class="[item.current ? 'bg-tertiary text-white' : 'text-gray-300 hover:bg-tertiary hover:text-white',
                        'group flex items-center px-2 py-2 text-lg font-medium rounded-md']">
                            <component :is="item.icon" :class="[item.current ? 'text-white' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true"/>
                            {{ item.label }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <!-- mobile menu button -->
                <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <MenuAlt2Icon class="h-6 w-6" aria-hidden="true"/>
                </button>
                <!-- top app header -->
                <div class="flex-1 px-4 flex justify-between bg-neutral items-center">
                    <h1 class="text-gray-600 ml-4 text-3xl">Community</h1>
                    <!-- search -->
<!--                    <div class="flex-1 flex">-->
<!--                        <form class="w-full flex md:ml-0" action="#" method="GET">-->
<!--                            <label for="search-field" class="sr-only">Search</label>-->
<!--                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">-->
<!--                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">-->
<!--                                    <SearchIcon class="h-5 w-5" aria-hidden="true"/>-->
<!--                                </div>-->
<!--                                <input id="search-field"-->
<!--                                       class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"-->
<!--                                       placeholder="Search" type="search" name="search"/>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button" class="p-1 mx-1 rounded-full text-gray-400 hover:text-primary focus:outline-none">
                            <span class="sr-only">View notifications</span>
                            <BookmarkIcon class="h-7 w-7" aria-hidden="true"/>
                        </button>
                        <button type="button" class="p-1 mr-2 rounded-full text-gray-400 hover:text-primary focus:outline-none">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-7 w-7" aria-hidden="true"/>
                        </button>
                        <!-- Profile dropdown -->
                        <Menu as="div" class="ml-3 relative">
                            <div>
                                <MenuButton
                                    class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary hover:ring-2 hover:ring-offset-2 hover:ring-primary">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-12 w-12 rounded-full"
                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt=""/>
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                                        leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sub-App main layout -->
        <main class="md:pl-64 flex flex-col">
            <slot></slot>
        </main>
    </div>
</template>

<script>
import {ref} from 'vue'
import {Dialog, DialogOverlay, Menu, MenuButton, MenuItem, MenuItems, TransitionChild, TransitionRoot,} from '@headlessui/vue'
import {AcademicCapIcon, BellIcon, CollectionIcon, DotsHorizontalIcon, InformationCircleIcon, MailIcon, MenuAlt2Icon, OfficeBuildingIcon, UsersIcon, BookmarkIcon, XIcon} from '@heroicons/vue/outline'
import {SearchIcon} from '@heroicons/vue/solid'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

const navigation = [
    {label: 'Community', name: 'home', icon: UsersIcon, current: true},
    {label: 'Notifications', name: 'notifications', icon: BellIcon, current: false},
    {label: 'Messages', name: 'messages', icon: MailIcon, current: false},
    {label: 'Projects', name: 'projects', icon: CollectionIcon, current: false},
    {label: 'Groups', name: 'groups', icon: InformationCircleIcon, current: false},
    {label: 'Learn', name: 'learn', icon: AcademicCapIcon, current: false},
    {label: 'Marketplace', name: 'marketplace', icon: OfficeBuildingIcon, current: false},
    {label: 'More', name: 'home', icon: DotsHorizontalIcon, current: false},
]
const userNavigation = [
    {name: 'Your Profile', href: '#'},
    {name: 'Settings', href: '#'},
    {name: 'Sign out', href: '#'},
]

export default {
    components: {
        Head,
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        BookmarkIcon,
        Link,
        Dialog,
        DialogOverlay,
        MailIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        BellIcon,
        MenuAlt2Icon,
        SearchIcon,
        CollectionIcon,
        InformationCircleIcon,
        XIcon,
    },
    setup() {
        const sidebarOpen = ref(false)

        return {
            navigation,
            userNavigation,
            sidebarOpen,
        }
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },

        logout() {
            this.$inertia.post(route('logout'));
        },
    }
}
</script>
