<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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

        <main class="pt-14">
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
