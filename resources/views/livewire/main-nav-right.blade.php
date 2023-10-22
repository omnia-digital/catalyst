@php use Filament\Facades\Filament; @endphp
{{-- Right Side Nav --}}
<div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex justify-end items-center mr-4">
    <!-- Search -->
    <livewire:partials.global-search/>
    @auth
        {{ Filament::renderHook('user-menu.start') }}
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
                        @if (auth()->user()->notifications()->whereNull('read_at')->count() > 0 )
                            <span class="ml-2 w-3 h-3 text-2xs absolute top-0 right-0 flex items-center justify-center text-white-text-color bg-danger-600 rounded-full">
                                                        {{ auth()->user()->notifications()->whereNull('read_at')->count() }}
                                                    </span>
                        @endif
                        <span class="sr-only">View notifications</span>
                    </a>
                </div>

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && auth()->user()->isMemberOfATeam())
                    <div class="md:relative mr-2">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <button type="button"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         src="{{ auth()->user()->currentTeam->profile_photo_url }}"
                                         alt="{{ auth()->user()->currentTeam->name }}"/>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Current Team -->
                                    <div class="block px-4 py-2 text-xs text-light-text-color">
                                        {{ Translate::get('Current Team') }}
                                    </div>
                                    <x-dropdown-link
                                            href="{{ route('catalyst-social.teams.show', auth()->user()->currentTeam->handle) }}">
                                        {{ auth()->user()->currentTeam->name }}
                                    </x-dropdown-link>

                                    {{--                                                                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())--}}
                                    {{--                                                                                <x-dropdown-link href="{{ route('teams.create') }}">--}}
                                    {{--                                                                                    {{ \Translate::get('Create New Team') }}--}}
                                    {{--                                                                                </x-dropdown-link>--}}
                                    {{--                                                                            @endcan--}}

                                    @if (auth()->user()->hasMultipleTeams())
                                        <div class="border-t border-gray-100"></div>

                                        <!-- Team Switcher -->
                                        <div class="block px-4 py-2 text-xs text-light-text-color">
                                            {{ Translate::get('Switch Teams') }}
                                        </div>

                                        @foreach (auth()->user()->teams as $team)
                                            <x-switchable-team :team="$team"/>
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="relative flex">
                    <x-dropdown align="right" width="48">

                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         src="{{ auth()->user()?->profile_photo_url }}"
                                         alt="{{ auth()->user()->name }}"/>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-secondary hover:text-dark-text-color focus:outline-none transition">
                                                    {{ auth()->user()->name }}
                                                    <div>
                                                        <img class="inline-block h-8 w-8 rounded-full"
                                                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                             alt=""/>
                                                    </div>
                                                    <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            {{ Filament::renderHook('user-menu.account.before') }}

                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-light-text-color">
                                {{ Translate::get('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('catalyst-social.profile.show', auth()->user()->handle) }}">
                                {{ auth()->user()->name }}
                            </x-dropdown-link>

                            {{--                            <x-dropdown-link href="{{ route('resources.drafts') }}">--}}
                            {{--                                My Resources--}}
                            {{--                            </x-dropdown-link>--}}

                            <x-dropdown-link href="{{ route('media.index') }}">
                                Media Library
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('account') }}">
                                {{ Translate::get('Account') }}
                            </x-dropdown-link>
                            {{ Filament::renderHook('user-menu.account.after') }}

                            @if (\OmniaDigital\CatalystCore\Facades\Catalyst::isUsingStripe())
                                <x-dropdown-link href="{{ route('billing.stripe-billing') }}">
                                    {{ Translate::get('Billing') }}
                                </x-dropdown-link>
                            @elseif (\OmniaDigital\CatalystCore\Facades\Catalyst::isUsingChargent() && \OmniaDigital\CatalystCore\Facades\Catalyst::isUsingUserSubscriptions())
                                <x-dropdown-link href="{{ route('billing.chargent-billing') }}">
                                    {{ Translate::get('Billing') }}
                                </x-dropdown-link>
                            @endif

                            {{--                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                            {{--                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">--}}
                            {{--                                        {{ \Translate::get('API Tokens') }}--}}
                            {{--                                    </x-dropdown-link>--}}
                            {{--                                @endif--}}

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                                 onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                    {{ Translate::get('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
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
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-secondary hover:text-dark-text-color focus:outline-none transition">
                                                    <div>
                                                        <x-heroicon-o-user class="inline-block h-5 w-5 rounded-full"/>
                                                    </div>
                                                    <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </span>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link href="{{ route('register') }}">
                    {{ Translate::get('Register') }}
                </x-dropdown-link>
                <x-dropdown-link href="{{ route('login') }}">
                    {{ Translate::get('Login') }}
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    @endauth
</div>


{{ Filament::renderHook('user-menu.end') }}
