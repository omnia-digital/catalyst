<div class="grid grid-cols-10 gap-2 bg-neutral">
    <livewire:social::layouts.module-navigation class="col-span-2"/>

    <div class="col-span-8">
        <div class="">
{{--            @if (Route::currentRouteName() !== 'social.profile.show')--}}
{{--                <div class="bg-neutral">--}}
{{--                    <div class="flex-1 flex items-center">--}}
{{--                        <h1 class="py-4 ml-4 text-3xl">Community</h1>--}}
{{--                        <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6"/>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

            <div class="min-h-screen ml-4">
                <!-- Page content -->
                <div class="mx-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

