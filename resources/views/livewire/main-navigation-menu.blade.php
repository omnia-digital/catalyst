<nav x-data="{ open: false }" class="fixed w-full bg-primary z-20 shadow-sm">
    <!-- Desktop Navigation Menu -->
    <div class="max-w-8xl mx-auto grid grid-cols-10 gap-2 h-14">
        <!-- Left side header -->
        <div class="col-span-2">
            <!-- Logo -->
            <div class="flex items-center h-14 flex-shrink-0">
                <a href="{{ route('social.home') }}"
                   title="{{ env('APP_NAME') }}"
                   class="bg-neutral-light text-black py-2 group flex justify-left items-center text-xl space-x-2 font-medium">
                    <x-dynamic-component
                            component="heroicon-s-globe-alt"
                            class="flex-shrink-0 h-6 w-6"
                            aria-hidden="true"
                    />
                    <span>{{ env('APP_NAME') }}</span>
                </a>
            </div>
        </div>
        <!-- Right side header -->
        <div class="col-span-8">
            <div class="flex space-x-6 items-center h-14">
                <!-- Navigation Links -->
                <nav class="hidden sm:block mx-auto max-w-2xl items-center space-x-4">
                    @foreach ($navigation as $item)
                        {{--                    @if(\Nwidart\Modules\Module::isModuleEnabled($item['module']))--}}
                        <x-main-nav-link href="{{ route($item['name']) }}" :active="request()->route()->named($item['module'] . '*')">
                            <x-dynamic-component
                                    :component="$item['icon']"
                                    class="flex-shrink-0 h-6 w-6 mr-2"
                                    aria-hidden="true"
                            />
                            {{ $item['label'] }}
                        </x-main-nav-link>
                        {{--                    @endif--}}
                    @endforeach
                </nav>
                <div class="hidden sm:flex max-w-sm w-full justify-between md:items-center">
                    <!-- Search -->
                    <div class="hidden md:flex w-full items-center">
                        <div class="w-full">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-search class="h-5 w-5 text-light-text-color dark:text-light-text-color" aria-hidden="true"/>
                                </div>
                                <input id="search" name="search"
                                       class="block w-full pl-10 pr-3 py-2 border border-neutral bg-neutral rounded-md leading-5 dark:bg-gray-700 text-light-text-color placeholder-light-text-color focus:outline-none focus:ring-dark-text-color sm:text-sm"
                                       placeholder="Search for Projects" type="search"/>
                            </div>
                        </div>
                    </div>
                    <!-- Notifications -->
{{--                    <div class="ml-4 flex items-center md:ml-6">
                       <button type="button" class="p-1 mr-2 relative rounded-full text-light-text-color hover:text-primary focus:outline-none">
                           <span class="sr-only">View notifications</span>
                           <x-heroicon-o-bell class="h-6 w-6"/>
                           <span class="ml-2 w-3 h-3 text-xxs absolute top-0 right-0 flex items-center justify-center text-white bg-black rounded-full">3</span>
                       </button>
                   </div> --}}

                    <!-- Teams Dropdown -->
                   @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                       <div class="ml-3 md:relative flex-1">
                           <x-jet-dropdown align="right" width="60">
                               <x-slot name="trigger">
                                       <span class="inline-flex rounded-md">
                                           <button type="button"
                                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-primary hover:bg-gray-50 hover:text-dark-text-color focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                               {{ Auth::user()->currentTeam->name }}

                                               <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                   <path fill-rule="evenodd"
                                                         d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                         clip-rule="evenodd"/>
                                               </svg>
                                           </button>
                                       </span>
                               </x-slot>

                               <x-slot name="content">
                                   <div class="w-60">
                                       <!-- Team Management -->
                                       <div class="block px-4 py-2 text-xs text-light-text-color">
                                           {{ __('Manage Team') }}
                                       </div>

                                       <!-- Team Settings -->
                                       <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                           {{ __('Team Settings') }}
                                       </x-jet-dropdown-link>

                                       @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                           <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                               {{ __('Create New Team') }}
                                           </x-jet-dropdown-link>
                                       @endcan

                                       <div class="border-t border-gray-100"></div>

                                       <!-- Team Switcher -->
                                       <div class="block px-4 py-2 text-xs text-light-text-color">
                                           {{ __('Switch Teams') }}
                                       </div>

                                       @foreach (Auth::user()->allTeams() as $team)
                                           <x-jet-switchable-team :team="$team"/>
                                       @endforeach
                                   </div>
                               </x-slot>
                           </x-jet-dropdown>
                       </div>
               @endif

{{--                <!-- Settings Dropdown -->--}}
{{--                    <div class="ml-3 relative flex">--}}
{{--                        <x-jet-dropdown align="right" width="48">--}}
{{--                            <x-slot name="trigger">--}}
{{--                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())--}}
{{--                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">--}}
{{--                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()?->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>--}}
{{--                                    </button>--}}
{{--                                @else--}}
{{--                                    <span class="inline-flex rounded-md">--}}
{{--                                        <button type="button"--}}
{{--                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-primary hover:text-dark-text-color focus:outline-none transition">--}}
{{--                                            {{ Auth::user()->name }}--}}
{{--                                            <div>--}}
{{--                                                <img class="inline-block h-8 w-8 rounded-full"--}}
{{--                                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"--}}
{{--                                                     alt=""/>--}}
{{--                                            </div>--}}
{{--                                            <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                                <path fill-rule="evenodd"--}}
{{--                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"--}}
{{--                                                      clip-rule="evenodd"/>--}}
{{--                                            </svg>--}}
{{--                                        </button>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </x-slot>--}}

{{--                            <x-slot name="content">--}}
{{--                                <!-- Account Management -->--}}
{{--                                <div class="block px-4 py-2 text-xs text-light-text-color">--}}
{{--                                    {{ __('Manage Account') }}--}}
{{--                                </div>--}}

{{--                                <x-jet-dropdown-link href="{{ route('profile.show') }}">--}}
{{--                                    {{ __('Profile') }}--}}
{{--                                </x-jet-dropdown-link>--}}

{{--                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
{{--                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">--}}
{{--                                        {{ __('API Tokens') }}--}}
{{--                                    </x-jet-dropdown-link>--}}
{{--                                @endif--}}

{{--                                <div class="border-t border-gray-100"></div>--}}

{{--                                <!-- Authentication -->--}}
{{--                                <form method="POST" action="{{ route('logout') }}">--}}
{{--                                    @csrf--}}

{{--                                    <x-jet-dropdown-link href="{{ route('logout') }}"--}}
{{--                                                         onclick="event.preventDefault();--}}
{{--                                                                    this.closest('form').submit();">--}}
{{--                                        {{ __('Log Out') }}--}}
{{--                                    </x-jet-dropdown-link>--}}
{{--                                </form>--}}
{{--                            </x-slot>--}}
{{--                        </x-jet-dropdown>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- Hamburger -->
    <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-light-text-color hover:text-base-text-color hover:bg-neutral focus:outline-none focus:bg-neutral focus:text-base-text-color transition">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
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
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

            <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-neutral-light"></div>

                    <div class="block px-4 py-2 text-xs text-light-text-color">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-neutral-light"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-light-text-color">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link"/>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
