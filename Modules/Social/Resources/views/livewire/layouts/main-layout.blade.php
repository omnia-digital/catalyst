<div>
    <div class="flex bg-neutral">
        <!-- SideMenu -->
        <livewire:social::layouts.module-navigation class="md:fixed md:w-64 pl-6 pt-4"/>

        <!-- Main Content -->
        <div class="md:pl-64 w-full flex flex-col">
            <div class="">
                {{--            @if (Route::currentRouteName() !== 'social.profile.show')--}}
                {{--                <div class="bg-neutral">--}}
                {{--                    <div class="flex-1 flex items-center">--}}
                {{--                        <h1 class="py-4 ml-4 text-3xl">Community</h1>--}}
                {{--                        <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6"/>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--            @endif--}}

                <div class="min-h-screen">
                    <!-- Page content -->
                    <div class="flex-1">
                        @hasSection('full-width-header')
                            <div class="">
                                @yield('full-width-header')
                            </div>
                        @endif
                        @yield('page-layout')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
