@props([
    'breadcrumbs' => [],
])

<header {{ $attributes->class([
    'filament-main-topbar sticky top-0 z-10 flex h-16 w-full shrink-0 items-center border-b bg-white',
    'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
]) }}>
    <div class="flex items-center w-full px-2 sm:px-4 md:px-6 lg:px-8">
        <button
                x-cloak
                x-data="{}"
                x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' : '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
                x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                @class([
                    'filament-sidebar-open-button shrink-0 flex items-center justify-center w-10 h-10 text-primary rounded-full hover:bg-gray-500/5 focus:bg-primary/10 focus:outline-none',
                    'lg:mr-4 rtl:lg:mr-0 rtl:lg:ml-4' => config('filament.layout.sidebar.is_collapsible_on_desktop'),
                    'lg:hidden' => ! (config('filament.layout.sidebar.is_collapsible_on_desktop') && (config('filament.layout.sidebar.collapsed_width') === 0)),
                ])
        >
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>

        <div :class="{'block': open, 'hidden': ! open}"
             class="hidden sm:hidden bg-secondary max-h-full-minus-[56px] overflow-y-scroll scrollbar-hide">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ Trans::get('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            @auth
                <div class="pt-4 pb-1 border-t border-neutral-light">
                    <div class="flex items-center px-4">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
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
                            {{ Trans::get('Profile') }}
                        </x-responsive-nav-link>

                        {{--                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                        {{--                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">--}}
                        {{--                        {{ \Trans::get('API Tokens') }}--}}
                        {{--                    </x-responsive-nav-link>--}}
                        {{--                @endif--}}

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ Trans::get('Log Out') }}
                            </x-responsive-nav-link>
                        </form>

                        <!-- Team Management -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->isMemberOfATeam())
                            <div class="border-t border-neutral-light"></div>

                            {{--                    <div class="block px-4 py-2 text-xs text-light-text-color">--}}
                            {{--                        {{ \Trans::get('Manage Team') }}--}}
                            {{--                    </div>--}}

                            <!-- Team Settings -->
                            <x-responsive-nav-link
                                    href="{{ route('social.teams.show', Auth::user()->currentTeam->id) }}"
                                    :active="request()->routeIs('teams.show')">
                                {{ Trans::get('Team Settings') }}
                            </x-responsive-nav-link>

                            {{--                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                            {{--                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">--}}
                            {{--                            {{ \Trans::get('Create New Team') }}--}}
                            {{--                        </x-responsive-nav-link>--}}
                            {{--                    @endcan--}}

                            @if(Auth::user()->hasMultipleTeams())
                                <div class="border-t border-neutral-light"></div>

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-light-text-color">
                                    {{ Trans::get('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->teams as $team)
                                    <x-switchable-team :team="$team" component="-link"/>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            @endauth
        </div>

        <div class="flex items-center justify-between flex-1">
            {{--            <x-filament::layouts.app.topbar.breadcrumbs :breadcrumbs="$breadcrumbs" />--}}
            <livewire:main-nav-left :navigation="\App\Livewire\MainNavigationMenu::getDefaultNavItems()"/>
            <livewire:main-nav-right/>

            {{--            @livewire('filament.core.global-search')--}}

            {{--            @livewire('filament.core.notifications')--}}

            {{--            <x-filament::layouts.app.topbar.user-menu />--}}
        </div>
    </div>
</header>
