<div>
    <div class="bg-neutral">
        <div class="flex-1 flex items-center">
            <h1 class="py-4 ml-4 text-3xl">Resources</h1>
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
            @yield('content')
        </div>
    </div>
</div>

