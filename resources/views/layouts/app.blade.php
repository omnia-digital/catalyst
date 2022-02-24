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

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    </head>
    <body class="h-full font-sans antialiased">

        <div>
            @livewire('navigation-menu')
            @livewire('side-menu2')

            <main class="md:pl-24 flex-1">
                <div>
                    <div class="bg-neutral">
                        <div class="flex-1 flex items-center">
                            <h1 class="py-4 ml-4 text-3xl">Home</h1>
                            <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6" />
                        </div>
                    </div>
                
                    <div class="min-h-screen bg-gray-100 px-4">
                        <nav class="max-w-7xl mx-auto border-b border-neutral">
                            <div class="md:hidden">
                                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                {{--                        @foreach($navigation as $item)--}}
                {{--                            <x-jet-button as="a" href="{{$item->href}}"--}}
                {{--                                                class="[{{$item->current}} ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base--}}
                {{--                                                font-medium']"--}}
                {{--                                             aria-current="{{$item->current}} ? 'page' : ''">--}}
                {{--                                   {{ $item->name }}--}}
                {{--                            </x-jet-button>--}}
                {{--                        @endforeach--}}
                                </div>
                            </div>
                        </nav>
                
                        <!-- Page content -->
                        <div class="mx-auto">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')
        @stack('scripts')
        @livewireScripts
        @env ('local')
            <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
