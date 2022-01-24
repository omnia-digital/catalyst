<template>
    <div class="bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
        <article :aria-labelledby="'question-title-' + post.id">
            <div>
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" :src="post.author.imageUrl" alt=""/>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">
                            <a :href="post.author.href" class="hover:underline">{{ post.author.name }}</a>
                        </p>
                        <p class="text-sm text-gray-500">
                            <a :href="post.href" class="hover:underline">
                                <time :datetime="post.datetime">{{ post.date }}</time>
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
                <h2 :id="'question-title-' + post.id" class="mt-4 text-base font-medium text-gray-900">
                    {{ post.title }}
                </h2>
            </div>
            <div class="mt-2 text-sm text-gray-700 space-y-4" v-html="post.body"/>
            <div class="mt-6 flex justify-between space-x-8">
                <div class="flex space-x-6">
                      <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <ThumbUpIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ post.likes }}</span>
                          <span class="sr-only">likes</span>
                        </button>
                      </span>
                    <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <ChatAltIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ post.replies }}</span>
                          <span class="sr-only">replies</span>
                        </button>
                      </span>
                    <span class="inline-flex items-center text-sm">
                        <button type="button" class="inline-flex space-x-2 text-gray-400 hover:text-gray-500">
                          <EyeIcon class="h-5 w-5" aria-hidden="true"/>
                          <span class="font-medium text-gray-900">{{ post.views }}</span>
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
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'
import {ChatAltIcon, CodeIcon, DotsVerticalIcon, EyeIcon, FlagIcon, PlusSmIcon, SearchIcon, ShareIcon, StarIcon, ThumbUpIcon,} from '@heroicons/vue/solid'
import {BellIcon, MenuIcon, XIcon} from '@heroicons/vue/outline'

export default defineComponent({
    name: "PostListItem",
    props: ['post'],

    components: {
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
        }
    },
})
</script>

<style scoped>

</style>
