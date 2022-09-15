<div>
    <div class="flex bg-neutral">
        <!-- SideMenu -->
        <livewire:social::layouts.module-navigation class="md:w-64 sm:pl-6 sm:pt-4"/>

        <!-- Main Content -->
        <div class="md:pl-64 w-full flex flex-col">
            <div>
                <div class="min-h-screen">
                    <!-- Page content -->
                    <div class="flex-1">
                        @hasSection('full-width-header')
                            <div class="">
                                @yield('full-width-header')
                            </div>
                        @endif
                        <div class="mx-4 sm:mx-0">
                            @yield('page-layout')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
