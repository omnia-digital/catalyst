<template>
  <div class="flex items-start bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <div class="flex-shrink-0">
      <img :src="user?.imageUrl" alt="" class="inline-block h-10 w-10 rounded-full"/>
    </div>
    <div>
    </div>
    <div class="min-w-0 flex-1">
      <form action="#" class="relative">

        <div class="flex justify-between">
          <div class="flex-1 px-2 rounded-lg overflow-hidden">
            <label class="sr-only" for="comment">What's going on?</label>
            <textarea id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" name="comment"
                      placeholder="What's going on?"
                      rows="1"/>

            <!-- Spacer element to match the height of the toolbar -->
            <div aria-hidden="true" class="py-2">
              <!-- Matches height of button in toolbar (1px border + 36px content height) -->
              <div class="py-px">
                <div class="h-9"/>
              </div>
            </div>
          </div>
          <Dropdown :options="postTypes"/>
        </div>

        <div class="absolute bottom-0 border-t border-gray-100 inset-x-0 pl-3 pr-2 pt-2 flex justify-between">
          <div class="flex items-center space-x-5">
            <div class="flex items-center">
              <button class="-m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500"
                      type="button">
                <PaperClipIcon aria-hidden="true" class="h-5 w-5"/>
                <span class="sr-only">Attach a file</span>
              </button>
            </div>
            <div class="flex items-center">
              <Listbox v-model="selected" as="div">
                <ListboxLabel class="sr-only">
                  Your mood
                </ListboxLabel>
                <div class="relative">
                  <ListboxButton
                      class="relative -m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500">
                                        <span class="flex items-center justify-center">
                                          <span v-if="selected.value === null">
                                            <EmojiHappyIcon aria-hidden="true" class="flex-shrink-0 h-5 w-5"/>
                                            <span class="sr-only">
                                              Add your mood
                                            </span>
                                          </span>
                                          <span v-if="!(selected.value === null)">
                                            <div
                                                :class="[selected.bgColor, 'w-8 h-8 rounded-full flex items-center justify-center']">
                                              <component :is="selected.icon"
                                                         aria-hidden="true"
                                                         class="flex-shrink-0 h-5 w-5 text-white-text-color"/>
                                            </div>
                                            <span class="sr-only">{{ selected.name }}</span>
                                          </span>
                                        </span>
                  </ListboxButton>

                  <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                              leave-to-class="opacity-0">
                    <ListboxOptions
                        class="absolute z-10 mt-1 -ml-6 w-60 bg-white shadow rounded-lg py-3 text-base ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm">
                      <ListboxOption v-for="mood in moods" :key="mood.value" v-slot="{ active }" :value="mood"
                                     as="template">
                        <li :class="[active ? 'bg-gray-100' : 'bg-white', 'cursor-default select-none relative py-2 px-3']">
                          <div class="flex items-center">
                            <div :class="[mood.bgColor, 'w-8 h-8 rounded-full flex items-center justify-center']">
                              <component :is="mood.icon" :class="[mood.iconColor, 'flex-shrink-0 h-5 w-5']"
                                         aria-hidden="true"/>
                            </div>
                            <span class="ml-3 block font-medium truncate">
                              {{ mood.name }}
                            </span>
                          </div>
                        </li>
                      </ListboxOption>
                    </ListboxOptions>
                  </transition>
                </div>
              </Listbox>
            </div>
          </div>
          <div class="flex-shrink-0">
            <Link as="button"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white-text-color bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                  href="/social/home"
                  preserve-scroll
                  type="submit"
            >
              Post
            </Link>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {defineComponent, ref} from 'vue'
import {
  EmojiHappyIcon,
  EmojiSadIcon,
  FireIcon,
  HeartIcon,
  PaperClipIcon,
  ThumbUpIcon,
  XIcon,
} from '@heroicons/vue/solid'
import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from '@headlessui/vue'
// import Dropdown from "@/Jetstream/Dropdown";
import Dropdown from '@/Components/Dropdown'

const moods = [
  {name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white-text-color', bgColor: 'bg-red-500'},
  {name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white-text-color', bgColor: 'bg-pink-400'},
  {name: 'Happy', value: 'happy', icon: EmojiHappyIcon, iconColor: 'text-white-text-color', bgColor: 'bg-green-400'},
  {name: 'Sad', value: 'sad', icon: EmojiSadIcon, iconColor: 'text-white-text-color', bgColor: 'bg-yellow-400'},
  {name: 'Thumbsy', value: 'thumbsy', icon: ThumbUpIcon, iconColor: 'text-white-text-color', bgColor: 'bg-blue-500'},
  {name: 'I feel nothing', value: null, icon: XIcon, iconColor: 'text-gray-400', bgColor: 'bg-transparent'},
]

const postTypes = [
  {
    label: 'General',
    icon: 'HeartIcon',
    selected: true
  },
  {
    label: 'Announcement',
    icon: 'HeartIcon'
  }
]

export default defineComponent({
  name: "NewPostBox",
  props: {
    user: Object
  },

  components: {
    Dropdown,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
    EmojiHappyIcon,
    PaperClipIcon,
  },
  setup() {
    const selected = ref(moods[5])

    return {
      moods,
      selected,
      postTypes
    }
  },
})
</script>
