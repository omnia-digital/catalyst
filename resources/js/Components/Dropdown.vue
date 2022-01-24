<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                <component :is="selected?.icon" class="mr-2 h-5 w-5" aria-hidden="true" />
                {{ selected?.label }}
                <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                <div class="py-1">
                    <MenuItem v-for="option in options" v-slot="{ active }">
                        <Link :href="option.link" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                            <component :is="option.icon" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                            {{ option.label}}
                        </Link>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
    ArchiveIcon,
    ArrowCircleRightIcon,
    ChevronDownIcon,
    DuplicateIcon,
    HeartIcon,
    PencilAltIcon,
    TrashIcon,
    UserAddIcon,
} from '@heroicons/vue/solid'
import { defineComponent, computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    name: "Dropdown",
    props: {
        options: Array
    },

    components: {
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        ArchiveIcon,
        Link,
        ArrowCircleRightIcon,
        ChevronDownIcon,
        DuplicateIcon,
        HeartIcon,
        PencilAltIcon,
        TrashIcon,
        UserAddIcon,
    },

    setup(props) {
        const selected = computed(() => {
            return props.options.find(item => item.selected)
        })

        return {
            selected
        }
    }
})
</script>
