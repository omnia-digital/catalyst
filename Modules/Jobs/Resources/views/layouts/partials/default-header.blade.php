<div class="mx-auto">
    <nav class="w-full flex justify-between">
        <div class="flex w-1/4 justify-start items-center">
            <a href="https://www.facebook.com/LaraContracts-103860234945415" target="_blank">
                <x-feathericon-facebook class="w-5 h-5 text-white hover:text-blue-400"/>
            </a>
            <a href="https://twitter.com/LaraContracts" target="_blank">
                <x-feathericon-twitter class="ml-2 w-5 h-5 text-white hover:text-blue-400"/>
            </a>
        </div>
        <div class="flex w-1/2 justify-center items-center">
            <a href="{{ route('home') }}" class="mx-4" aria-label="Home">
                <img class="h-8 w-auto sm:h-10" src="{{ asset('images/logo-white.png') }}"
                     alt="{{ config('app.name') }}">
            </a>
        </div>
        <div class="flex w-1/4 justify-end items-center">
            @auth()
            @else
                <a href="{{ route('login') }}"
                   class="mr-4 inline-flex items-center text-base leading-6 font-medium text-white transition duration-150 ease-in-out">
                    Login
                </a>
            @endauth

            <span class="hidden sm:inline-flex rounded-md shadow">
                <a href="{{ route('jobs.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-black bg-white hover:text-gray-600 focus:outline-none focus:border-light-blue-300 focus:shadow-outline-light-blue active:bg-gray-50 active:text-light-blue-700 transition duration-150 ease-in-out">
                    Post a job
                </a>
            </span>

            @auth()

                <!-- Hamburger -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none text-white transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Profile dropdown -->
                <div x-data="{ open: false }"
                     x-on:click.away="open = false"
                     class="md:block hidden ml-4  flex-shrink-0"
                >
                    <div>
                        <button
                                x-on:click="open = !open"
                                x-bind:aria-expanded="open"
                                aria-haspopup="true"
                                id="user-menu"
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-light-blue-300 transition duration-150 ease-in-out"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->gravatar() }}"
                                 alt="{{ Auth::user()->name }}">
                        </button>
                    </div>

                    <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg"
                    >
                        <div class="py-1 rounded-md bg-white shadow-xs" role="menu">
                            <a href="{{ route('profile.show') }}"
                               class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                               role="menuitem">
                                Profile
                            </a>
                            <a href="{{ route('jobs') }}"
                               class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                               role="menuitem">
                                My Jobs
                            </a>
                            <a href="{{ route('profile.transactions') }}"
                               class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                               role="menuitem">
                                Transactions
                            </a>

                            <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                               class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                               role="menuitem">
                                Company Settings
                            </a>

                            {{--                        <a href="{{ route('teams.create') }}"--}}
                            {{--                           class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" role="menuitem">--}}
                            {{--                            Create New Company--}}
                            {{--                        </a>--}}

                            <!-- Company Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Companies') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team"/>
                            @endforeach

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();this.closest('form').submit();"
                                   class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                   role="menuitem"
                                >
                                    Sign out
                                </a>
                            </form>
                        </div>
                    </div>

                </div>
            @else
                <div class="flex items-center md:hidden">
                    <button
                            x-on:click="open = !open"
                            x-bind:aria-expanded="open"
                            aria-expanded="true"
                            class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-700 hover:bg-white focus:outline-none focus:bg-white focus:text-gray-700 transition duration-150 ease-in-out"
                    >
                        <span class="sr-only">Open menu</span>
                        <x-heroicon-o-menu
                                x-bind:class="{ 'hidden': open, 'block': !open }"
                                class="h-6 w-6 hidden"
                                aria-hidden="true"
                        />
                    </button>
                </div>
            @endauth
        </div>
    </nav>
</div>

<!-- Mobile menu -->
<div
        x-show="open"
        x-transition:enter="duration-150 ease-out"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="duration-100 ease-in"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden"
        style="display: none;"
>
    <div class="rounded-lg shadow-md">
        <div class="rounded-lg bg-white shadow-xs overflow-hidden" role="menu" aria-orientation="vertical"
             aria-labelledby="main-menu">
            <div class="px-5 pt-4 flex items-center justify-between">
                <div>
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                </div>
                <div class="-mr-2">
                    <button x-on:click="open = false" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            aria-label="Close menu">
                        <x-heroicon-s-x class="h-6 w-6"/>
                    </button>
                </div>
            </div>
            <div class="px-2 pt-2 pb-3">
                <a href="{{ route('jobs.create') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out"
                   role="menuitem">
                    Post a job
                </a>
            </div>
        </div>
    </div>
</div>
