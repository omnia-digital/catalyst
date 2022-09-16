<div>
    <div class="flex bg-neutral">
        <!-- SideMenu -->
        <livewire:social::layouts.module-navigation class="md:fixed md:w-64 pl-6 pt-4"/>

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
                        @yield('page-layout')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
