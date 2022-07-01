<div>
    @hasSection('full-width-header')
        <div class="">
            @yield('full-width-header')
        </div>
    @endif
    <div class="max-w-9xl mx-auto grid grid-cols-10 gap-4 bg-neutral @hasSection('full-width-header') pt-6 @else  @endif">

        <!-- Main Content -->
        <div class="col-span-10">
            <div class="">

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
