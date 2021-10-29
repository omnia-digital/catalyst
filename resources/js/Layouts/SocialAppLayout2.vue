<template>
    <div>
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
                </TransitionChild>
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0"
                                 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-5" leave-to="-translate-x-full">
                    <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                            <div class="absolute top-0 right-0 -mr-12 pt-2">
                                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>
                            </div>
                        </TransitionChild>
                        <div class="flex-shrink-0 flex items-center px-4">
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow" />
                        </div>
                        <div class="mt-5 flex-1 h-0 overflow-y-auto">
                            <nav class="px-2 space-y-1">
                                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                                    <component :is="item.icon" :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
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
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow" />
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
                            <component :is="item.icon" :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                            {{ item.name }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <!-- Mobile menu button -->
                <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
                </button>
                <!-- header -->
                <!-- Page Navigation -->
                <nav class="bg-white border-b border-gray-100">
                    <!-- Primary Navigation Menu -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Logo -->
                                <div class="flex-shrink-0 flex items-center">
                                    <Link :href="route('dashboard')">
                                        <jet-application-mark class="block h-9 w-auto" />
                                    </Link>
                                </div>

                                <!-- Navigation Links -->
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                        Dashboard
                                    </jet-nav-link>
                                </div>
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <div class="ml-3 relative">
                                    <!-- Teams Dropdown -->
                                    <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">
                                        <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <!-- Team Management -->
                                                <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Manage Team
                                                    </div>

                                                    <!-- Team Settings -->
                                                    <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                                                        Team Settings
                                                    </jet-dropdown-link>

                                                    <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                                        Create New Team
                                                    </jet-dropdown-link>

                                                    <div class="border-t border-gray-100"></div>

                                                    <!-- Team Switcher -->
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Switch Teams
                                                    </div>

                                                    <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                                        <form @submit.prevent="switchToTeam(team)">
                                                            <jet-dropdown-link as="button">
                                                                <div class="flex items-center">
                                                                    <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                    <div>{{ team.name }}</div>
                                                                </div>
                                                            </jet-dropdown-link>
                                                        </form>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </jet-dropdown>
                                </div>

                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <jet-dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <jet-dropdown-link :href="route('profile.show')">
                                                Profile
                                            </jet-dropdown-link>

                                            <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                                API Tokens
                                            </jet-dropdown-link>

                                            <div class="border-t border-gray-100"></div>

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <jet-dropdown-link as="button">
                                                    Log Out
                                                </jet-dropdown-link>
                                            </form>
                                        </template>
                                    </jet-dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                        <div class="pt-2 pb-3 space-y-1">
                            <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </jet-responsive-nav-link>
                        </div>

                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>
                                    <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                    Profile
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                    API Tokens
                                </jet-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <jet-responsive-nav-link as="button">
                                        Log Out
                                    </jet-responsive-nav-link>
                                </form>

                                <!-- Team Management -->
                                <template v-if="$page.props.jetstream.hasTeamFeatures">
                                    <div class="border-t border-gray-200"></div>

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Team
                                    </div>

                                    <!-- Team Settings -->
                                    <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                        Team Settings
                                    </jet-responsive-nav-link>

                                    <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                        Create New Team
                                    </jet-responsive-nav-link>

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <jet-responsive-nav-link as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </jet-responsive-nav-link>
                                        </form>
                                    </template>
                                </template>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <form class="w-full flex md:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <SearchIcon class="h-5 w-5" aria-hidden="true" />
                                </div>
                                <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" placeholder="Search" type="search" name="search" />
                            </div>
                        </form>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                        </button>

                        <!-- Profile dropdown -->
                        <Menu as="div" class="ml-3 relative">
                            <div>
                                <MenuButton class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
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

            <!-- Sub-App main layout -->
<!--            <main>-->
<!--                <slot></slot>-->
<!--            </main>-->
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import {
    Dialog,
    DialogOverlay,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    BellIcon,
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    MenuAlt2Icon,
    UsersIcon,
    XIcon,
    AcademicCapIcon,
    OfficeBuildingIcon,
    DotsHorizontalIcon
} from '@heroicons/vue/outline'
import { SearchIcon } from '@heroicons/vue/solid'

const navigation = [
    { name: 'Community', href: '#', icon: HomeIcon, current: true },
    { name: 'Messages', href: '#', icon: UsersIcon, current: false },
    { name: 'Learn', href: '#', icon: AcademicCapIcon, current: false },
    { name: 'Marketplace', href: '#', icon: OfficeBuildingIcon, current: false },
    { name: 'More', href: '#', icon: DotsHorizontalIcon, current: false },
]
const userNavigation = [
    { name: 'Your Profile', href: '#' },
    { name: 'Settings', href: '#' },
    { name: 'Sign out', href: '#' },
]

export default {
    components: {
        Dialog,
        DialogOverlay,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        TransitionChild,
        TransitionRoot,
        BellIcon,
        MenuAlt2Icon,
        SearchIcon,
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
}
</script>
