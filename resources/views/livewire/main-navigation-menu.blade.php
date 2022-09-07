<nav x-data="{ open: false }" class="fixed w-full bg-primary z-50 shadow-sm h-14">
    <div class="flex justify-between items-center sm:block">
        <!-- Desktop Navigation Menu -->
        <div class="flex justify-between items-center w-full">
            <!-- Left side header -->
            <div class="flex md:w-64 pl-4">
                <!-- Logo -->
                <div class="flex items-center h-14 flex-shrink-0">
                    <a href="{{ route('social.home') }}"
                       title="{{ env('APP_NAME') }}"
                       class="text-base-text-color py-2 group flex justify-left items-center text-xl space-x-2 font-medium">
                        @if(config('app.logo_path'))
                            <div class="flex items-center h-14 flex-shrink-0">
                                @if(config('app.theme_light_type') === 'light')
                                    <img src="{{ config('app.logo_path') }}" class="h-full"/>
                                @else
                                    <img src="{{ config('app.logo_path_dark') }}" class="h-full"/>
                                @endif
                            </div>
                        @else
                            <x-dynamic-component
                                    component="heroicon-s-globe-alt"
                                    class="flex-shrink-0 h-6 w-6"
                                    aria-hidden="true" />
                            <span class="whitespace-nowrap">{{ env('APP_NAME') }}</span>
                        @endif
                    </a>
                </div>
            </div>
            <!-- Right side header -->
            <div class="flex flex-1 grid grid-cols-12 h-14 items-center">
                <!-- Navigation Links -->
                <div class="hidden sm:flex col-span-9 justify-center items-center ">
                    <nav class="space-x-4 flex justify-center">
                        @foreach ($navigation as $item)
                            @if(\Platform::isModuleEnabled($item['module']))
                                <x-main-nav-link href="{{ route($item['name']) }}" :active="request()->route()->named($item['module'] . '*')">
                                    <x-dynamic-component
                                            :component="$item['icon']"
                                            class="flex-shrink-0 h-6 w-6 mr-2"
                                            aria-hidden="true"
                                    />
                                    {{ $item['label'] }}
                                </x-main-nav-link>
                            @endif
                        @endforeach
                    </nav>
                </div>
                <div class="hidden sm:flex col-span-3 mr-4 justify-between md:items-center">
                    <!-- Search -->
                    <div class="hidden md:flex flex-1 items-center">
                        <div class="w-full">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-search class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
                                </div>
                                <input id="search" name="search"
                                       class="block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm"
                                       placeholder="Search" type="search"/>
                            </div>
                        </div>
                    </div>
                    <!-- Notifications -->
                    <div class="mx-3 flex items-center">
                        <a href="{{ route('notifications') }}"
                           title="Notifications"
                           class="{{ request()->routeIs('notifications') ? 'font-semibold text-secondary' : 'text-light-text-color hover:text-secondary' }}
                            {{ 'relative rounded-full w-full p-1 group flex justify-left items-center text-xl space-x-2 font-medium' }}"
                           aria-current="page">
                            <x-dynamic-component
                                    component="heroicon-o-bell"
                                    class="flex-shrink-0 h-6 w-6"
                                    aria-hidden="true"
                            />
                            @if(Auth::user()
        ->notifications()->whereNull('read_at')->count() > 0 )
                                <span class="ml-2 w-3 h-3 text-2xs absolute top-0 right-0 flex items-center justify-center text-white-text-color bg-danger-600 rounded-full">{{ Auth::user()
                    ->notifications()->whereNull('read_at')->count() }}</span>
                            @endif
                            <span class="sr-only">View notifications</span>
                        </a>
                    </div>

                    <!-- Teams Dropdown -->
                    {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->isMemberOfATeam())
                        <div class="md:relative">
                            <x-jet-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button type="button"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->currentTeam->profile_photo_url }}" alt="{{ Auth::user()->currentTeam->name }}"/>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Current Team -->
                                        <div class="block px-4 py-2 text-xs text-light-text-color">
                                            {{ \Trans::get('Current Team') }}
                                        </div>
                                        <x-jet-dropdown-link href="{{ route('social.teams.show', Auth::user()->currentTeam->handle) }}">
                                            {{  Auth::user()->currentTeam->name }}
                                        </x-jet-dropdown-link>

                                                                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                                                    <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                                                        {{ \Trans::get('Create New Team') }}
                                                                                    </x-jet-dropdown-link>
                                                                                @endcan

                                        @if(Auth::user()->hasMultipleTeams())
                                            <div class="border-t border-gray-100"></div>

                                            <!-- Team Switcher -->
                                            <div class="block px-4 py-2 text-xs text-light-text-color">
                                                {{ \Trans::get('Switch Teams') }}
                                            </div>

                                            @foreach (Auth::user()->teams as $team)
                                                <x-jet-switchable-team :team="$team"/>
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    @endif --}}

                    <!-- Settings Dropdown -->
                    <div class="relative flex">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()?->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-primary hover:text-dark-text-color focus:outline-none transition">
                                                {{ Auth::user()->name }}
                                                <div>
                                                    <img class="inline-block h-8 w-8 rounded-full"
                                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                         alt=""/>
                                                </div>
                                                <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-light-text-color">
                                    {{ \Trans::get('Manage Account') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('social.profile.show', auth()->user()->handle) }}">
                                    {{ auth()->user()->name }}
                                </x-jet-dropdown-link>

                                {{--                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                                {{--                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">--}}
                                {{--                                        {{ \Trans::get('API Tokens') }}--}}
                                {{--                                    </x-jet-dropdown-link>--}}
                                {{--                                @endif--}}

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                        {{ \Trans::get('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hamburger -->
    <div class="ml-auto inline-block sm:hidden">
        <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-light-text-color hover:text-base-text-color hover:bg-neutral focus:outline-none focus:bg-neutral focus:text-base-text-color transition">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden max-h-full-minus-[56px] overflow-y-scroll scrollbar-hide">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ \Trans::get('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-neutral-light">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base-text-color text-dark-text-color">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-base-text-color">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ \Trans::get('Profile') }}
                </x-jet-responsive-nav-link>

                {{--                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                {{--                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">--}}
                {{--                        {{ \Trans::get('API Tokens') }}--}}
                {{--                    </x-jet-responsive-nav-link>--}}
                {{--                @endif--}}

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ \Trans::get('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->isMemberOfATeam())
                    <div class="border-t border-neutral-light"></div>

                    {{--                    <div class="block px-4 py-2 text-xs text-light-text-color">--}}
                    {{--                        {{ \Trans::get('Manage Team') }}--}}
                    {{--                    </div>--}}

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('social.teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ \Trans::get('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    {{--                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                    {{--                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">--}}
                    {{--                            {{ \Trans::get('Create New Team') }}--}}
                    {{--                        </x-jet-responsive-nav-link>--}}
                    {{--                    @endcan--}}

                    @if(Auth::user()->hasMultipleTeams())
                        <div class="border-t border-neutral-light"></div>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-light-text-color">
                            {{ \Trans::get('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->teams as $team)
                            <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link"/>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
