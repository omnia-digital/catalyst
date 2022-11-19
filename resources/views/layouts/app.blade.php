<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.ga_tag_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ config('analytics.ga_tag_id') }}');
        </script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Platform') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles
        @libraryStyles

        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <script src="https://kit.fontawesome.com/d81fb76c88.js" crossorigin="anonymous"></script>
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

        @livewireScripts
        @livewireCalendarScripts

        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
