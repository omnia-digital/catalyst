<div class="flex-1 relative text-left">
    <div type="button" wire:click="goToProfile"
         class="group w-full flex rounded-md  text-sm text-left font-medium text-gray-700
                        hover:cursor-pointer"
         id="options-menu-button" aria-expanded="false" aria-haspopup="true">
        <div class="w-full justify-between items-center">
            <div class="w-full min-w-0 items-center justify-between space-y-2">
                <img class="w-24 h-24 bg-gray-300 rounded-full flex-shrink-0" src="{{ $user->profile_photo_url }}" alt="">
                <div class="space-y-2">
                    <div class="">
                        <p class="text-gray-900 text-lg font-medium truncate">{{ $user->name }}</p>
                        <p class="-mt-1 text-gray-500 text-md truncate">{{ '@'.$user?->handle }}</p>
                    </div>
                    <div class="flex mt-1">
                        <div class="bg-black flex items-center rounded-lg p-1">
                            <div class="grow-0 bg-primary text-xs rounded-md p-1">
                                {{ $user->level ?? '48' }}
                            </div>
                            <div class="grow-0 text-xs text-white px-1">
                                {{ $user->score ?? '3758' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Heroicon name: solid/selector -->
            {{-- @NOTE: Only show if user can select multiple teams/users}}
            {{--                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"--}}
            {{--                                     aria-hidden="true">--}}
            {{--                                    <path fill-rule="evenodd"--}}
            {{--                                          d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"--}}
            {{--                                          clip-rule="evenodd"/>--}}
            {{--                                </svg>--}}
        </div>
        <span class="sr-only">Open user menu</span>
    </div>
</div>
