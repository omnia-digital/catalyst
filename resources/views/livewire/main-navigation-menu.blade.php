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
                        @if (config('app.logo_path'))
                            <div class="flex items-center h-14 flex-shrink-0">
                                @if (config('app.theme_light_type') === 'light')
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
            </div>
            <div class="flex w-full justify-between h-full items-center pl-4">
                <div class="w-full grid grid-cols-12 gap-4">
                    <!-- Main nav header -->
                    <livewire:main-nav-left :navigation="$navigation"/>
                    <livewire:main-nav-right/>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden bg-secondary max-h-full-minus-[56px] overflow-y-scroll scrollbar-hide">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ Translate::get('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-neutral-light">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                 alt="{{ Auth::user()->name }}"/>
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-dark-text-color">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-base-text-color">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}"
                                           :active="request()->routeIs('profile.show')">
                        {{ Translate::get('Profile') }}
                    </x-responsive-nav-link>

                    {{--                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                    {{--                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">--}}
                    {{--                        {{ \Translate::get('API Tokens') }}--}}
                    {{--                    </x-responsive-nav-link>--}}
                    {{--                @endif--}}

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ Translate::get('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->isMemberOfATeam())
                        <div class="border-t border-neutral-light"></div>

                        {{--                    <div class="block px-4 py-2 text-xs text-light-text-color">--}}
                        {{--                        {{ \Translate::get('Manage Team') }}--}}
                        {{--                    </div>--}}

                        <!-- Team Settings -->
                        <x-responsive-nav-link href="{{ route('social.teams.show', Auth::user()->currentTeam->id) }}"
                                               :active="request()->routeIs('teams.show')">
                            {{ Translate::get('Team Settings') }}
                        </x-responsive-nav-link>

                        {{--                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                        {{--                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">--}}
                        {{--                            {{ \Translate::get('Create New Team') }}--}}
                        {{--                        </x-responsive-nav-link>--}}
                        {{--                    @endcan--}}

                        @if (Auth::user()->hasMultipleTeams())
                            <div class="border-t border-neutral-light"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-light-text-color">
                                {{ Translate::get('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->teams as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link"/>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @endauth
    </div>
</nav>
