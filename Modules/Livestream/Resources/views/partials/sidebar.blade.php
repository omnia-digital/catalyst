<div class="hidden bg-white overflow-y-auto md:block">
    <div class="w-full py-6 px-2 flex flex-col items-center">
        <div class="flex-shrink-0 flex items-center">
            <img class="h-8 w-auto" src="{{ asset('images/common/omnia-logo-full.svg') }}"
                 alt="{{ config('app.name') }}">
        </div>
        <div class="flex-1 mt-2 w-full px-2 space-y-1">
            <x-sidebar-title name="Account"/>
            <x-sidebar-item name="Dashboard" :to="route('dashboard')" icon="heroicon-o-chart-bar"
                            :isSelected="request()->routeIs('dashboard')"/>
            <x-sidebar-item name="Settings" :to="route('settings')" icon="heroicon-o-cog"
                            :isSelected="in_array(request()->route()->getName(), ['settings.video', 'settings.livestream-account'])"/>

            <x-sidebar-title name="Episodes"/>
            <x-sidebar-item name="Episodes" :to="route('episodes')" icon="heroicon-o-photograph"
                            :isSelected="in_array(request()->route()->getName(), ['episodes', 'episodes.show'])"/>
            <x-sidebar-item name="Series" :to="route('series')" icon="heroicon-o-color-swatch"
                            :isSelected="in_array(request()->route()->getName(), ['series', 'series.update'])"/>
            <x-sidebar-item name="People" :to="route('people')" icon="heroicon-o-users"
                            :isSelected="in_array(request()->route()->getName(), ['people', 'people.show', 'people.update'])"/>
            <x-sidebar-item name="Templates" :to="route('episode-templates')" icon="heroicon-o-template"
                            :isSelected="in_array(request()->route()->getName(), ['episode-templates', 'episode-templates.update'])"/>

            <x-sidebar-title name="Streaming"/>
            <x-sidebar-item name="Streams" :to="route('streams')" icon="heroicon-o-video-camera"
                            :isSelected="request()->routeIs('streams')"/>
            <x-sidebar-item name="Stream Targets" :to="route('stream-targets')"
                            icon="heroicon-o-presentation-chart-line"
                            :isSelected="in_array(request()->route()->getName(), ['stream-targets', 'stream-targets.update'])"/>

            <x-sidebar-title name="Watch"/>
            <x-sidebar-item name="Players" :to="route('players')" icon="heroicon-o-play"
                            :isSelected="in_array(request()->route()->getName(), ['players', 'players.show'])"/>
            <x-sidebar-item name="Channels" :to="route('channels')" icon="heroicon-o-desktop-computer"
                            :isSelected="in_array(request()->route()->getName(), ['channels', 'channels.show', 'channels.update'])"/>
            <x-sidebar-item name="Playlists" :to="route('playlists')" icon="fa-solid fa-rectangle-history"
                            :isSelected="in_array(request()->route()->getName(), ['playlists', 'playlists.update'])"/>
        </div>
    </div>
</div>
