<div>
    @hasSection('full-width-header')
        <div class="">
            @yield('full-width-header')
        </div>
    @endif
    <div class="max-w-8xl mx-auto grid grid-cols-10 gap-4 bg-neutral @hasSection('full-width-header') pt-6 @else  @endif">
        <!-- SideMenu -->
        <livewire:games::layouts.module-navigation class="col-span-2 pt-6"/>

        <!-- Main Content -->
        <div class="col-span-8">
            <div class="">
                <livewire:games::components.search-dropdown/>

                {{--            @if (Route::currentRouteName() !== 'social.profile.show')--}}
                {{--                <div class="bg-neutral">--}}
                {{--                    <div class="flex-1 flex items-center">--}}
                {{--                        <x-library::heading.1 class="py-4 ml-4 text-3xl">Community</x-library::heading.1>--}}
                {{--                        <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6"/>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}

                <div class="min-h-screen">
                    <!-- Page content -->
                    <div class="mx-auto">
                        @yield('page-layout')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
