<div>
    <div class="flex bg-neutral">
        <!-- SideMenu -->
        <livewire:social::layouts.module-navigation class=""/>

        <!-- Main Content -->
        <div class="lg:pl-64 w-full flex flex-col">
            <div>
                <div class="min-h-screen">
                    <!-- Page content -->
                    <div class="flex-1">
                        @hasSection('full-width-header')
                            <div class="">
                                @yield('full-width-header')
                            </div>
                        @endif
                        <div>
                            @yield('page-layout')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
