<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('components.external.gtag-head')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Omnia Church Apps') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @include('components.external.gist')
    <script src="https://kit.fontawesome.com/61862e0cef.js" crossorigin="anonymous"></script>
</head>
<body class="font-sans antialiased">
@include('components.external.gtag-body')

{{ $slot }}

<x-notification/>

@stack('modals')

@stack('scripts')

@livewireScriptConfig

</body>
</html>
