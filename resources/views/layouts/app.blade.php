<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <x-layouts.partials.gtags />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Platform') }}</title>

        <x-layouts.partials.fonts/>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
        @libraryStyles

        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <x-layouts.partials.fontawesome/>
    </head>
    <body class="{{ config('app.theme') }} h-full bg-neutral font-sans antialiased">

        <!-- App Navigation -->
        <livewire:main-navigation-menu/>

        <main class="pb-20 lg:pb-4 pt-14">
            {{ $slot }}
        </main>

        <x-library::notification/>

        @libraryScripts

        @stack('modals')
        @stack('scripts')

        <x-impersonate::banner/>
        @livewireScripts
        @livewireCalendarScripts

        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '{{ config('services.facebook.client_id') }}',
                    cookie     : true,
                    xfbml      : true,
                    version    : '{{ config('services.facebook.version') }}'
                });

                FB.AppEvents.logPageView();

            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
