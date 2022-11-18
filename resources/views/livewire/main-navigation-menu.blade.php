<nav x-data="{ open: false }" class="fixed w-full bg-secondary z-50 shadow-sm h-14">
    <div class="flex justify-between items-center">
        <!-- Desktop Navigation Menu -->
        <div class="flex items-center justify-between w-full">
            <!-- Logo area header -->
            <div class="flex w-2/3 md:w-72 pl-2 lg:pl-4 pr-4 md:pr-0 space-x-4 md:space-x-1">
                <!-- Logo -->
                <div class="flex items-center h-14 flex-shrink-0">
                    <a href="{{ route('social.home') }}"
                       title="{{ env('APP_NAME') }}"
                       class="text-base-text-color py-2 group flex justify-left items-center text-xl space-x-2 font-medium">
                        @if(config('app.logo_path'))
                            <div class="flex items-center h-14 flex-shrink-0">
                                @if(config('app.theme_light_type') === 'light')
                                    <img src="{{ config('app.logo_path') }}" class="h-10"/>
                                @else
                                    <img src="{{ config('app.logo_path_dark') }}" class="h-10"/>
                                @endif
                            </div>
                        @else
                            <x-library::icons.icon name="fa-duotone fa-earth-americas" size="w-6 h-6"/>
                            <span class="whitespace-nowrap">{{ env('APP_NAME') }}</span>
                        @endif
                    </a>
                </div>
                <!-- Search -->
                <livewire:global-search/>
            </div>
            <!-- Main nav header -->
            <div class="flex w-full justify-between h-full items-center pl-4">
                <div class="w-full grid grid-cols-12 gap-4">
                    <!-- Center Nav -->
                    <div class="hidden lg:block sm:col-span-8 2xl:col-span-9 justify-center items-center">
                        <nav class="space-x-4 flex justify-center">
                            @foreach ($navigation as $item)
                                @if(\Platform::isModuleEnabled($item['module']))
                                    <x-main-nav-link href="{{ route($item['name']) }}" :active="request()->route()->named($item['module'] . '*')">
                                        <x-library::icons.icon :name="$item['icon']" class="w-6 h-6 mr-2"/>
                                        {{ $item['label'] }}
                                    </x-main-nav-link>
                                @endif
                            @endforeach
                            @if(config('feedback.roadmap.url'))
                                <x-main-nav-link href="{{ config('feedback.roadmap.url') }}" target="_blank">
                                    <x-library::icons.icon name="fa-solid fa-road" class="w-6 h-6 mr-2"/>
                                    {{ Trans::get('Roadmap') }}
                                </x-main-nav-link>
                            @endif
                        </nav>
                    </div>
                    {{-- Right Side Nav --}}
                    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex justify-end items-center mr-4">
                        @auth
                            {{-- Profile & Notifications --}}
                            <div class="flex justify-end">
                                <div class="flex col-span-4 2xl:col-span-3 justify-between md:items-center">
                                    <!-- Notifications -->
                                    <div class="mx-3 flex items-center">
                                        <a href="{{ route('notifications') }}"
                                           title="Notifications"
                                           class="{{ request()->routeIs('notifications') ? 'font-semibold text-primary' : 'text-light-text-color hover:text-primary' }}
                                {{ 'relative rounded-full w-full p-1 group flex justify-left items-center text-xl space-x-2 font-medium' }}"
                                           aria-current="page">
                                            <x-library::icons.icon name="heroicon-o-bell"/>
                                            @if(Auth::user()->notifications()->whereNull('read_at')->count() > 0 )
                                                <span class="ml-2 w-3 h-3 text-2xs absolute top-0 right-0 flex items-center justify-center text-white-text-color bg-danger-600 rounded-full">
                                                        {{ Auth::user()->notifications()->whereNull('read_at')->count() }}
                                                    </span>
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
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-secondary hover:text-dark-text-color focus:outline-none transition">
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

                                                <x-jet-dropdown-link href="{{ route('account') }}">
                                                    {{ \Trans::get('Account') }}
                                                </x-jet-dropdown-link>

                                                @if (\App\Support\Platform\Platform::isUsingStripe())
                                                    <x-jet-dropdown-link href="{{ route('billing.stripe-billing') }}">
                                                        {{ \Trans::get('Billing') }}
                                                    </x-jet-dropdown-link>
                                                @elseif (\App\Support\Platform\Platform::isUsingChargent() && \App\Support\Platform\Platform::isUsingUserSubscriptions())
                                                    <x-jet-dropdown-link href="{{ route('billing.chargent-billing') }}">
                                                        {{ \Trans::get('Billing') }}
                                                    </x-jet-dropdown-link>
                                                @endif

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
                                <!-- Mobile Hamburger -->
                                {{--                            <div class="inline-block sm:hidden sm:ml-auto  mr-2">--}}
                                {{--                                <button @click="open = ! open"--}}
                                {{--                                        class="inline-flex items-center justify-center p-2 rounded-md text-light-text-color hover:text-base-text-color hover:bg-neutral focus:outline-none focus:bg-neutral focus:text-base-text-color transition">--}}
                                {{--                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">--}}
                                {{--                                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
                                {{--                                              d="M4 6h16M4 12h16M4 18h16"/>--}}
                                {{--                                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>--}}
                                {{--                                    </svg>--}}
                                {{--                                </button>--}}
                                {{--                            </div>--}}
                            </div>
                        @else
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-secondary hover:text-dark-text-color focus:outline-none transition">
                                                    <div>
                                                        <x-heroicon-o-user class="inline-block h-5 w-5 rounded-full"/>
                                                    </div>
                                                    <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-jet-dropdown-link href="{{ route('register') }}">
                                        {{ \Trans::get('Register') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('login') }}">
                                        {{ \Trans::get('Login') }}
                                    </x-jet-dropdown-link>
                                </x-slot>
                            </x-jet-dropdown>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-secondary max-h-full-minus-[56px] overflow-y-scroll scrollbar-hide">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ \Trans::get('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-neutral-light">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-dark-text-color">{{ Auth::user()->name }}</div>
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
        @endauth
    </div>
</nav>
