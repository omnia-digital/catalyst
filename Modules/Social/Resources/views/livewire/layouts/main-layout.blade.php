<div>
    <livewire:social::layouts.module-navigation/>

    <div class="md:pl-24">
        <div class="bg-neutral">
            <div class="flex-1 flex items-center">
                <h1 class="py-4 ml-4 text-3xl">Community</h1>
                <x-heroicon-o-cog class="mt-1 ml-3 w-6 h-6"/>
            </div>
        </div>

        <div class="min-h-screen bg-gray-100 px-4">
            <!-- Page content -->
            <div class="mx-auto">
                @yield('content')
            </div>
        </div>
    </div>
</div>

