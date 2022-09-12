<template>
    <social-app-layout title="Profile">
        <!-- Page Heading -->
        <div>
            <!-- Profile Background Pic -->
            <img class="h-32 w-full object-cover lg:h-48" :src="profile.backgroundImage" alt=""/>
        </div>
        <div class="my-6 max-w-5xl mx-auto lg:grid lg:grid-cols-9 lg:gap-9">
            <div class="lg:col-span-6 xl:col-span-6">
                <!-- Profile Info -->
                <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:pl-6 lg:pr-2">
                    <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                        <div class="flex">
                            <img class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32" :src="profile.avatar" alt=""/>
                        </div>
                        <div class="mt-2 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-4">
                            <div class="mt-2 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                                <button type="button"
                                        class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    <i></i>
                                    <span>Edit Profile</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-start mt-2 min-w-0 flex-1">
                        <x-library::heading.1 class="text-2xl font-bold text-gray-900 truncate">
                            {{ profile.name }}
                        </x-library::heading.1>
                        <p class="text-sm text-gray-600">{{ profile.handle }}</p>
                    </div>
                    <div class="mt-2 text-sm">
                        <p>Indie Game Dev creating
                            <a href="#" class="text-primary">@_ProjectCanopy_</a>
                            Wishlist: <a href="#" class="text-primary">https://bit.ly/2JFWHz4</a> Website: <a href="#" class="text-primary">https://projectcanopygame.com</a> YT:
                            <a href="#" class="text-primary">https://bit.ly/3gzERd2</a>
                        </p>
                    </div>
                    <div class="flex space-x-3 my-2 items-center">
                        <!-- Location -->
                        <div class="flex items-center space-x-1">
                            <i class="fa-light fa-map-marker-alt"></i>
                            <p>USA</p>
                        </div>
                        <a href="https://socksandgoats.com" class="flex items-center space-x-1">
                            <i class="fa-light fa-link"></i>
                            <p class="text-primary">socksandgoats.com</p>
                        </a>
                        <div class="flex items-center space-x-1">
                            <i class="fa-light fa-calendar-alt"></i>
                            <p>Joined March 2020</p>
                        </div>
                    </div>
                    <div class="flex space-x-5 my-2 items-center">
                        <p><span class="font-bold">1,645</span> <span class="text-gray-600">Following</span></p>
                        <p><span class="font-bold">1,191</span> <span class="text-gray-600">Followers</span></p>
                    </div>
                </div>
                <!-- Tabs -->
                <div class="max-w-5xl mx-auto">
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select a tab</label>
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" name="tabs"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex" aria-label="Tabs">
                                <a v-for="tab in tabs" :key="tab.name" :href="tab.href"
                                   :class="[tab.current ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-200 hover:border-gray-300',
                                   'whitespace-nowrap py-4 px-10 border-b-2 font-bold']"
                                   :aria-current="tab.current ? 'page' : undefined">
                                    {{ tab.name }}
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- My Feed -->
                <div class="mt-4">
                    <x-library::heading.1 class="sr-only">Recent questions</x-library::heading.1>
                    <ul role="list" class="space-y-4">
                        <li v-for="question in questions" :key="question.id" class="bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
                            <article :aria-labelledby="'question-title-' + question.id">
                                <div>
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full" :src="question.author.imageUrl" alt=""/>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                <a :href="question.author.href" class="hover:underline">{{ question.author.name }}</a>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                <a :href="question.href" class="hover:underline">
                                                    <time :datetime="question.datetime">{{ question.date }}</time>
                                                </a>
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 self-center flex">
                                            <Menu as="div" class="relative inline-block text-left">
                                                <div>
                                                    <MenuButton class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                        <span class="sr-only">Open options</span>
                                                        <DotsVerticalIcon class="h-5 w-5" aria-hidden="true"/>
                                                    </MenuButton>
                                                </div>

                                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
                                                            enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
                                                            leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                                    <MenuItems class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                        <div class="py-1">
                                                            <MenuItem v-slot="{ active }">
                                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                                    <StarIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                                    <span>Add to favorites</span>
                                                                </a>
                                                            </MenuItem>
                                                            <MenuItem v-slot="{ active }">
                                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                                    <CodeIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                                    <span>Embed</span>
                                                                </a>
                                                            </MenuItem>
                                                            <MenuItem v-slot="{ active }">
                                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                                    <FlagIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                                    <span>Report content</span>
                                                                </a>
                                                            </MenuItem>
                                                        </div>
                                                    </MenuItems>
                                                </transition>
                                            </Menu>
                                        </div>
                                    </div>
                                    <x-library::heading.2 :id="'question-title-' + question.id" class="mt-4 text-base font-medium text-gray-900">
                                        {{ question.title }}
                                    </x-library::heading.2>
                                </div>
                                <div class="mt-2 text-sm text-gray-700 space-y-4" v-html="question.body"/>
                                <div class="mt-6 flex justify-between space-x-8">
                                    <div class="flex space-x-6">
                      <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <ThumbUpIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ question.likes }}</span>
                          <span class="sr-only">likes</span>
                        </button>
                      </span>
                                        <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <ChatAltIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ question.replies }}</span>
                          <span class="sr-only">replies</span>
                        </button>
                      </span>
                                        <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <EyeIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ question.views }}</span>
                          <span class="sr-only">views</span>
                        </button>
                      </span>
                                    </div>
                                    <div class="flex text-sm">
                      <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <ShareIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">Share</span>
                        </button>
                      </span>
                                    </div>
                                </div>
                            </article>
                        </li>
                    </ul>
                </div>
            </div>
            <aside class="hidden xl:block xl:col-span-3">
                <div class="sticky top-4 space-y-4">
                    <section aria-labelledby="who-to-follow-heading">
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-6">
                                <x-library::heading.2 id="who-to-follow-heading" class="text-base font-medium text-gray-900">
                                    Who to follow
                                </x-library::heading.2>
                                <div class="mt-6 flow-root">
                                    <ul role="list" class="-my-4 divide-y divide-gray-200">
                                        <li v-for="user in whoToFollow" :key="profile.handle" class="flex items-center py-4 space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" :src="user.imageUrl" alt=""/>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <a :href="user.href">{{ user.name }}</a>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <a :href="user.href">{{ '@' + profile.handle }}</a>
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="inline-flex items-center px-3 py-0.5 rounded-full bg-rose-50 text-sm font-medium text-rose-700 hover:bg-rose-100">
                                                    <PlusSmIcon class="-ml-1 mr-0.5 h-5 w-5 text-rose-400" aria-hidden="true"/>
                                                    <span>
                              Follow
                            </span>
                                                </button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section aria-labelledby="trending-heading">
                        <div class="bg-white rounded-lg shadow">
                            <div class="p-6">
                                <x-library::heading.2 id="trending-heading" class="text-base font-medium text-gray-900">
                                    Trending
                                </x-library::heading.2>
                                <div class="mt-6 flow-root">
                                    <ul role="list" class="-my-4 divide-y divide-gray-200">
                                        <li v-for="post in trendingPosts" :key="post.id" class="flex py-4 space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" :src="post.user.imageUrl" :alt="post.user.name"/>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm text-gray-800">{{ post.body }}</p>
                                                <div class="mt-2 flex">
                            <span class="inline-flex items-center text-sm">
                              <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                                <ChatAltIcon class="h-5 w-5" aria-hidden="true"/>
                                <span class="font-medium text-gray-900">{{ post.comments }}</span>
                              </button>
                            </span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a href="#" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </social-app-layout>
</template>

<script>
import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'
import {ChatAltIcon, CodeIcon, DotsVerticalIcon, EyeIcon, FlagIcon, PlusSmIcon, SearchIcon, ShareIcon, StarIcon, ThumbUpIcon,} from '@heroicons/vue/solid'
import {BellIcon, FireIcon, HomeIcon, MenuIcon, TrendingUpIcon, UserGroupIcon, XIcon} from '@heroicons/vue/outline'
import SocialAppLayout from '../Layouts/SocialAppLayout.vue'
import {defineComponent} from 'vue'

const profile = {
    name: 'Ricardo Cooper',
    handle: '@rcooper',
    email: 'ricardo.cooper@example.com',
    avatar:
        'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
    backgroundImage:
        'https://images.unsplash.com/photo-1444628838545-ac4016a5418a?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
    fields: [
        ['Phone', '(555) 123-4567'],
        ['Email', 'ricardocooper@example.com'],
        ['Title', 'Senior Front-End Developer'],
        ['Team', 'Product Development'],
        ['Location', 'San Francisco'],
        ['Sits', 'Oasis, 4th floor'],
        ['Salary', '$145,000'],
        ['Birthday', 'June 8, 1990'],
    ],
}
const user = {
    name: 'Chelsea Hagon',
    email: 'chelseahagon@example.com',
    imageUrl:
        'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}
const navigation = [
    {label: 'Home', name: 'home', icon: HomeIcon, current: true},
    {label: 'Explore', name: 'explore', icon: TrendingUpIcon, current: false},
    {label: 'Teams', name: 'teams', icon: FireIcon, current: false},
    {label: 'My Profile', name: 'profile', icon: UserGroupIcon, current: false},
]
const userNavigation = [
    {name: 'Your Profile', href: '#'},
    {name: 'Settings', href: '#'},
    {name: 'Sign out', href: '#'},
]
const communities = [
    {name: 'Movies', href: '#'},
    {name: 'Food', href: '#'},
    {name: 'Sports', href: '#'},
    {name: 'Animals', href: '#'},
    {name: 'Science', href: '#'},
    {name: 'Dinosaurs', href: '#'},
    {name: 'Talents', href: '#'},
    {name: 'Gaming', href: '#'},
]
const tabs = [
    {name: 'Timeline', href: '#', current: true},
    {name: 'Media', href: '#', current: false},
    {name: 'Likes', href: '#', current: false},
]
const questions = [
    {
        id: '81614',
        likes: '29',
        replies: '11',
        views: '2.7k',
        author: {
            name: 'Dries Vincent',
            imageUrl:
                'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            href: '#',
        },
        date: 'December 9 at 11:43 AM',
        datetime: '2020-12-09T11:43:00',
        href: '#',
        title: 'What would you have done differently if you ran Jurassic Park?',
        body: `
      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
    `,
    },
    {
        id: '81614',
        likes: '29',
        replies: '11',
        views: '2.7k',
        author: {
            name: 'Dries Vincent',
            imageUrl:
                'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            href: '#',
        },
        date: 'December 9 at 11:43 AM',
        datetime: '2020-12-09T11:43:00',
        href: '#',
        title: 'What would you have done differently if you ran Jurassic Park?',
        body: `
      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
    `,
    },
    {
        id: '81614',
        likes: '29',
        replies: '11',
        views: '2.7k',
        author: {
            name: 'Dries Vincent',
            imageUrl:
                'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            href: '#',
        },
        date: 'December 9 at 11:43 AM',
        datetime: '2020-12-09T11:43:00',
        href: '#',
        title: 'What would you have done differently if you ran Jurassic Park?',
        body: `
      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
    `,
    },
    {
        id: '81614',
        likes: '29',
        replies: '11',
        views: '2.7k',
        author: {
            name: 'Dries Vincent',
            imageUrl:
                'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            href: '#',
        },
        date: 'December 9 at 11:43 AM',
        datetime: '2020-12-09T11:43:00',
        href: '#',
        title: 'What would you have done differently if you ran Jurassic Park?',
        body: `
      <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
      <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
    `,
    },
]
const whoToFollow = [
    {
        name: 'Leonard Krasner',
        handle: 'leonardkrasner',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Leonard Krasner',
        handle: 'leonardkrasner',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Leonard Krasner',
        handle: 'leonardkrasner',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
]
const trendingPosts = [
    {
        id: 1,
        user: {
            name: 'Floyd Miles',
            imageUrl:
                'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        body: 'What books do you have on your bookshelf just to look smarter than you actually are?',
        comments: 291,
    },
    {
        id: 1,
        user: {
            name: 'Floyd Miles',
            imageUrl:
                'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        body: 'What books do you have on your bookshelf just to look smarter than you actually are?',
        comments: 291,
    },
    {
        id: 1,
        user: {
            name: 'Floyd Miles',
            imageUrl:
                'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        body: 'What books do you have on your bookshelf just to look smarter than you actually are?',
        comments: 291,
    },
]

export default defineComponent({
    components: {
        SocialAppLayout,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Popover,
        PopoverButton,
        PopoverPanel,
        BellIcon,
        ChatAltIcon,
        CodeIcon,
        DotsVerticalIcon,
        EyeIcon,
        FlagIcon,
        MenuIcon,
        PlusSmIcon,
        SearchIcon,
        ShareIcon,
        StarIcon,
        ThumbUpIcon,
        XIcon,
    },
    setup() {
        return {
            user,
            navigation,
            userNavigation,
            communities,
            tabs,
            questions,
            whoToFollow,
            trendingPosts
        }
    },
    props: {
        profile: Object,
    },
})
</script>
