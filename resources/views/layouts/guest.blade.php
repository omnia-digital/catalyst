<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <!-- Styles -->
    {{--        <link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @filamentStyles
    <!-- Styles -->
    @livewireStyles
    <!-- Scripts -->
    {{--        <script src="{{ mix('js/app.js') }}" defer></script>--}}
</head>
<body>
<div class="font-sans text-dark-text-color antialiased">
    {{ $slot }}
</div>
@filamentScripts
@livewireScripts
</body>
</html>
