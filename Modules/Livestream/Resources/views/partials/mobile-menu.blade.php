<div
        x-data="{
        show: false
    }"
        x-show="show"
        x-on:open-mobile-menu.window="show = true"
        class="fixed inset-0 z-40 flex md:hidden"
        role="dialog" aria-modal="true"
        style="display: none"
>
    <div
            x-show="show"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

    <div
            x-show="show"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative max-w-xs w-full bg-white pb-4 flex-1 flex flex-col"
    >
        <div
                s-show="show"
                x-transition:enter="ease-in-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute top-1 right-0 -mr-14 p-1 pt-0"
        >
            <button x-on:click="show = false" type="button"
                    class="h-12 w-12 rounded-full flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-white">
                <x-library::icons.icon name="x-mark" class="h-6 w-6 text-white"/>
                <span class="sr-only">Close sidebar</span>
            </button>
        </div>

        <div class="flex-shrink-0 px-4 mt-6 mb-2 flex items-center">
            <img class="h-16 w-auto" src="{{ asset('images/common/omnia-logo-horizontal.svg') }}"
                 alt="{{ config('app.name') }}">
        </div>
        <div class=" flex-1 h-0 px-2 overflow-y-auto">
            <nav x-on:click.away="show = false" class="h-full flex flex-col">
                <div class="space-y-1">
                    <x-sidebar-title name="Account"/>
                    <x-mobile-menu-item name="Dashboard" :to="route('dashboard')" icon="heroicon-o-home"
                                        :isSelected="request()->routeIs('dashboard')"/>
                    <x-mobile-menu-item name="Settings" :to="route('settings')" icon="heroicon-o-cog"
                                        :isSelected="request()->routeIs('settings')"/>

                    <x-sidebar-title name="Episodes"/>
                    <x-mobile-menu-item name="Episodes" :to="route('episodes')" icon="heroicon-o-photograph"
                                        :isSelected="request()->routeIs('episodes')"/>
                    <x-mobile-menu-item name="Series" :to="route('series')" icon="heroicon-o-color-swatch"
                                        :isSelected="request()->routeIs('series')"/>
                    <x-mobile-menu-item name="People" :to="route('people')" icon="heroicon-o-users"
                                        :isSelected="request()->routeIs('people')"/>
                    <x-mobile-menu-item name="Templates" :to="route('episode-templates')" icon="heroicon-o-template"
                                        :isSelected="request()->routeIs('episode-templates')"/>

                    <x-sidebar-title name="Streaming"/>
                    <x-mobile-menu-item name="Streams" :to="route('streams')" icon="heroicon-o-video-camera"
                                        :isSelected="request()->routeIs('streams')"/>
                    <x-mobile-menu-item name="Stream Targets" :to="route('stream-targets')"
                                        icon="heroicon-o-presentation-chart-line"
                                        :isSelected="request()->routeIs('stream-targets')"/>

                    <x-sidebar-title name="Watch"/>
                    <x-mobile-menu-item name="Players" :to="route('players')" icon="heroicon-o-play"
                                        :isSelected="request()->routeIs('players')"/>
                    <x-mobile-menu-item name="Channels" :to="route('channels')" icon="heroicon-o-desktop-computer"
                                        :isSelected="request()->routeIs('channels')"/>
                    <x-mobile-menu-item name="Playlists" :to="route('playlists')" icon="heroicon-o-collection"
                                        :isSelected="in_array(request()->route()->getName(), ['playlists', 'playlists.update'])"/>

                </div>
            </nav>
        </div>
    </div>

    <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
    </div>
</div>
