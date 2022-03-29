<a href="{{ route('social.profile.show', ['profile'=> Auth::user()->profile]) }}">
    <div class="w-full flex relative text-left">
        <div>
            <div type="button"
                 class="group w-full bg-gray-200 border border-neutral-hover px-5 flex rounded-md py-4 text-sm text-left font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2
                 focus:ring-offset-2
                 focus:ring-offset-gray-100 focus:ring-purple-500"
                 id="options-menu-button" aria-expanded="false" aria-haspopup="true">
                <div class="flex w-full justify-between items-center">
                    <div class="flex min-w-0 items-center justify-between space-x-3">
                        <img class="w-20 h-20 bg-gray-300 rounded-full flex-shrink-0" src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2
                .1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80" alt="">
                        <div class="min-w-0">
                            <div class="">
                                <p class="text-gray-900 text-md font-medium truncate">{{ Auth::user()->name }}</p>
                                <p class="-mt-1 text-gray-500 text-xs truncate">{{ '@'.Auth::user()->profile?->handle }}</p>
                            </div>
                            <div class="flex mt-1">
                                <div class="bg-black flex items-center rounded-lg p-1">
                                    <div class="grow-0 bg-primary text-xs rounded-md p-1">
                                        {{ Auth::user()->level ?? '48' }}
                                    </div>
                                    <div class="grow-0 text-xs text-white px-1">
                                        {{ Auth::user()->score ?? '3758' }}
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
            </div>
        </div>
    </div>
</a>
