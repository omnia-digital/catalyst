<div class="flex items-start bg-white px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <div class="flex-shrink-0">
        <img class="inline-block h-10 w-10 rounded-full" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" />
    </div>
    <div></div>
    <div class="min-w-0 flex-1">
        <form action="#" class="relative" wire:submit.prevent="savePost">

            <div class="flex justify-between">
                <div class="flex-1 px-2 rounded-lg overflow-hidden">
                    <label for="title" class="sr-only">Post Title</label>
                    <input 
                        type="text"  name="title" id="title" 
                        class="block w-full py-1 border-0 resize-none focus:ring-0 sm:text-sm" 
                        placeholder="Title" 
                        wire:model.defer="title"
                    >
                    @error('title') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    
                    <label for="body" class="sr-only">What's going on?</label>
                    <input 
                        type="text"  name="body" id="body" 
                        class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm" 
                        placeholder="What's going on?" 
                        wire:model.defer="body"
                    >
                    @error('body') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
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
                            <div x-data="{ open: false }" class="relative">
                                <button  
                                    @click="open = true" 
                                    type="button"
                                    class="relative -m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-500"
                                >
                                    <span class="flex items-center justify-center">
                                        @if (is_null($selected['value']))
                                            <x-heroicon-o-emoji-happy class="flex-shrink-0 h-5 w-5" aria-hidden="true"  />
                                            <span class="sr-only">
                                                Add your mood
                                                </span>
                                        @endif
                                        @if (!is_null($selected['value']))
                                            <div class="{{ $selected['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center' }}">
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

                                <div 
                                    x-show="open" @click.away="open = false"
                                    x-transition:enter.duration.100ms
                                    x-transition:enter.opacity.0
                                    x-transition:enter.scale.95
                                    x-transition:leave.duration.75ms
                                    x-transition:leave.opacity.100
                                    x-transition:leave.scale.100
                                >
                                    <ul class="absolute z-10 mt-1 -ml-6 w-60 bg-white shadow rounded-lg py-3 text-base ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm">
                                        @foreach ($moods as $mood)
                                            <li class="bg-white cursor-default select-none relative py-2 px-3">
                                                <div class="flex items-center">
                                                    <div class="{{ $mood['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center' }}">
                                                        <x-dynamic-component :component="$mood['icon']" class="{{ $mood['iconColor'] . ' flex-shrink-0 h-5 w-5' }}" aria-hidden="true"  />
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <button type="submit" class="w-full block text-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Post</button>
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
