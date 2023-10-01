<template>
  <div>
    <div class="flex-1 flex px-4 sm justify-between bg-neutral items-center">
      <x-library::heading.1 class="text-gray-600 ml-4">Community</x-library::heading.1>
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
        <button class="p-1 mx-1 rounded-full text-gray-400 hover:text-primary focus:outline-none" type="button">
          <span class="sr-only">View notifications</span>
          <BookmarkIcon aria-hidden="true" class="h-7 w-7"/>
        </button>
        <button class="p-1 mr-2 rounded-full text-gray-400 hover:text-primary focus:outline-none" type="button">
          <span class="sr-only">View notifications</span>
          <BellIcon aria-hidden="true" class="h-7 w-7"/>
        </button>
        <!-- Profile dropdown -->
        <Menu as="div" class="ml-3 relative">
          <div>
            <MenuButton
                class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary hover:ring-2 hover:ring-offset-2 hover:ring-primary">
              <span class="sr-only">Open user menu</span>
              <img alt=""
                   class="h-12 w-12 rounded-full"
                   src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"/>
            </MenuButton>
          </div>
          <transition enter-active-class="transition ease-out duration-100"
                      enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                      leave-active-class="transition ease-in duration-75"
                      leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
              <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                <a :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                   :href="item.href">{{ item.name }}</a>
              </MenuItem>
            </MenuItems>
          </transition>
        </Menu>
      </div>
    </div>

    <div class="min-h-screen bg-gray-100 px-4 sm:px-0">
      <Disclosure v-slot="{ open }" as="nav" class="max-w-6xl mx-auto border-b border-neutral">
        <div>
          <div class="flex h-16 justify-between">
            <div class="-ml-2 mr-2 flex items-center md:hidden">
              <!-- Mobile menu button -->
              <DisclosureButton
                  class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white-text-color hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <span class="sr-only">Open main menu</span>
                <MenuIcon v-if="!open" aria-hidden="true" class="block h-6 w-6"/>
                <XIcon v-else aria-hidden="true" class="block h-6 w-6"/>
              </DisclosureButton>
            </div>
            <div class="hidden md:flex md:items-center space-x-8">
              <jet-nav-link v-for="item in navigation" :key="item.name" :active="route().current(item.name)"
                            :href="route(item.name)">
                <component :is="item.icon" aria-hidden="true" class="mr-3 flex-shrink-0 h-6 w-6"/>
                {{ item.label }}
              </jet-nav-link>
            </div>
            <div class="flex justify-center px-2 lg:ml-6 lg:justify-end items-center">
              <div class="max-w-lg w-full lg:max-w-xs">
                <label class="sr-only" for="search">Search</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <SearchIcon aria-hidden="true" class="h-5 w-5 dark:text-gray-400"/>
                  </div>
                  <input id="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 dark:bg-gray-700 text-gray-300 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-white focus:ring-white focus:text-gray-900 sm:text-sm"
                         name="search"
                         placeholder="Search" type="search"/>
                </div>
              </div>
            </div>
          </div>
        </div>


        <DisclosurePanel class="md:hidden">
          <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <DisclosureButton v-for="item in navigation" :key="item.name" :aria-current="item.current ? 'page' : undefined" :class="[item.current ? 'bg-gray-900 text-white-text-color' : 'text-gray-300 hover:bg-gray-700 hover:text-white-text-color', 'block px-3 py-2 rounded-md text-base font-medium']"
                              :href="item.href"
                              as="a">{{ item.name }}
            </DisclosureButton>
          </div>
          <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5 sm:px-6">
              <div class="flex-shrink-0">
                <img :src="user?.imageUrl" alt="" class="h-10 w-10 rounded-full"/>
              </div>
              <div class="ml-3">
                <div class="text-base font-medium text-white-text-color">{{ user?.name }}</div>
                <div class="text-sm font-medium text-gray-400">{{ user?.email }}</div>
              </div>
              <button class="ml-auto flex-shrink-0 bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white-text-color focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                      type="button">
                <span class="sr-only">View notifications</span>
                <BellIcon aria-hidden="true" class="h-6 w-6"/>
              </button>
            </div>
            <div class="mt-3 px-2 space-y-1 sm:px-3">
              <DisclosureButton v-for="item in userNavigation" :key="item.name" :href="item.href" as="a"
                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white-text-color hover:bg-gray-700">
                {{ item.name }}
              </DisclosureButton>
            </div>
          </div>
        </DisclosurePanel>
      </Disclosure>

      <!-- Page content -->
      <div class="max-w-6xl mx-auto">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  Popover,
  PopoverButton,
  PopoverPanel,
} from '@headlessui/vue'
import {
  BellIcon,
  BookmarkIcon,
  HashtagIcon,
  HomeIcon,
  MenuIcon,
  OfficeBuildingIcon,
  UserGroupIcon,
  UserIcon,
  XIcon
} from '@heroicons/vue/outline'
import {PlusSmIcon, SearchIcon} from '@heroicons/vue/solid'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import {Head} from '@inertiajs/inertia-vue3';
import {defineComponent} from "vue";

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
  {label: 'Teams', name: 'teams', icon: OfficeBuildingIcon, current: false},
  {label: 'Groups', name: 'groups', icon: UserGroupIcon, current: false},
]
const userNavigation = [
  {name: 'Your Profile', href: '#'},
  {name: 'Settings', href: '#'},
  {name: 'Sign out', href: '#'},
]

// const user = {
//     name: 'Chelsea Hagon',
//     handle: 'chelseahagon',
//     email: 'chelseahagon@example.com',
//     role: 'Human Resources Manager',
//     imageId: '1550525811-e5869dd03032',
//     imageUrl:
//         'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
// }

export default defineComponent({
  props: {
    user: Object
  },
  components: {
    BookmarkIcon,
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
      navigation,
      userNavigation,
    }
  },
})
</script>
