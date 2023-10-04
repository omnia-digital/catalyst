<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-layouts.partials.gtags/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Catalyst') }}</title>

    <x-layouts.partials.fonts/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <!-- Styles -->
    {{--        <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}

    @filamentStyles
    @libraryStyles

    @stack('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <!-- Scripts -->
    {{--        <script src="{{ mix('js/app.js') }}" defer></script>--}}
    <x-layouts.partials.fontawesome/>
</head>
<body class="{{ config('app.theme') }} h-full bg-neutral font-sans antialiased">
<x-banner/>

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

@filamentScripts
@livewireCalendarScripts
@livewireScriptConfig

</body>
</html>
