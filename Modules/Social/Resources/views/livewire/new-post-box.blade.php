<div class="flex items-start bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <div class="flex-shrink-0">
        <img class="inline-block h-10 w-10 rounded-full" src="{{ $user->imageUrl }}" alt="" />
    </div>
    <div></div>
    <div class="min-w-0 flex-1">
        <form action="#" class="relative">

            <div class="flex justify-between">
                <div class="flex-1 px-2 rounded-lg overflow-hidden">
                    <label for="comment" class="sr-only">What's going on?</label>
                    <textarea rows="1" name="comment" id="comment" class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" placeholder="What's going on?"></textarea>

                    <!-- Spacer element to match the height of the toolbar -->
                    <div class="py-2" aria-hidden="true">
                        <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                        <div class="py-px">
                            <div class="h-9"></div>
                        </div>
                    </div>
                </div>
                {{-- <x-jet-dropdown :content="$postTypes" :trigger="'trigger'" /> --}}
            </div>

            <div class="absolute bottom-0 border-t border-gray-100 inset-x-0 pl-3 pr-2 pt-2 flex justify-between">
                <div class="flex items-center space-x-5">
                    <div class="flex items-center">
                        <button type="button" class="-m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500">
                            <x-heroicon-o-paper-clip class="h-5 w-5" aria-hidden="true" />
                            <span class="sr-only">Attach a file</span>
                        </button>
                    </div>
                    <div class="flex items-center">
                        <div wire:model="selected">
                            <span class="sr-only">
                                Your mood
                            </span>
                            <div class="relative">
                                <button class="relative -m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500">
                                        <span class="flex items-center justify-center">
                                            @if (is_null($selected['value']))
                                                <x-heroicon-o-emoji-happy class="flex-shrink-0 h-5 w-5" aria-hidden="true"  />
                                                <span class="sr-only">
                                                    Add your mood
                                                  </span>
                                            @endif
                                            @if (!is_null($selected['value']))
                                                <div :class="$selected['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center'">
                                                    <x-dynamic-component :component="$selected['icon']" class="flex-shrink-0 h-5 w-5 text-white" aria-hidden="true"  />
                                                </div>
                                                <span class="sr-only">{{ $selected['name'] }}</span>
                                            @endif
                                          {{-- <span v-if="selected.value === null">
                                            <EmojiHappyIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                            <span class="sr-only">
                                              Add your mood
                                            </span>
                                          </span> --}}
                                            {{--     <span v-if="!(selected.value === null)">
                                                <div :class="[selected.bgColor, 'w-8 h-8 rounded-full flex items-center justify-center']">
                                                <component :is="selected.icon" class="flex-shrink-0 h-5 w-5 text-white" aria-hidden="true" />
                                                </div>
                                                <span class="sr-only">{{ selected.name }}</span>
                                            </span> --}}
                                        </span>
                                    </button>

                                <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                    <ul class="absolute z-10 mt-1 -ml-6 w-60 bg-white shadow rounded-lg py-3 text-base ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm">
                                        @foreach ($moods as $mood)
                                            <li class="bg-white cursor-default select-none relative py-2 px-3">
                                                <div class="flex items-center">
                                                    <div :class="$mood['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center'">
                                                        <x-dynamic-component :component="$mood['icon']" :class="$mood['iconColor'] . ' flex-shrink-0 h-5 w-5'" aria-hidden="true"  />
                                                    </div>
                                                    <span class="ml-3 block font-medium truncate">{{ $mood['name'] }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                        {{-- <ListboxOption as="template" v-for="mood in moods" :key="mood.value" :value="mood" v-slot="{ active }">
                                            <li :class="[active ? 'bg-gray-100' : 'bg-white', 'cursor-default select-none relative py-2 px-3']">
                                                <div class="flex items-center">
                                                    <div :class="[mood.bgColor, 'w-8 h-8 rounded-full flex items-center justify-center']">
                                                        <component :is="mood.icon" :class="[mood.iconColor, 'flex-shrink-0 h-5 w-5']" aria-hidden="true" />
                                                    </div>
                                                    <span class="ml-3 block font-medium truncate">{{ mood.name }}</span>
                                                </div>
                                            </li>
                                        </ListboxOption> --}}
                                    </ul>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
{{--                    <Link href="/social/home"--}}
{{--                          as="button"--}}
{{--                          type="submit"--}}
{{--                          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"--}}
{{--                          preserve-scroll--}}
{{--                    >--}}
{{--                    Post--}}
{{--                    </Link>--}}
                </div>
            </div>
        </form>
    </div>
</div>
