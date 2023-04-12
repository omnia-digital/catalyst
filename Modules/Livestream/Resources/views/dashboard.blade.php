<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-6 lg:space-y-12">
            <h1 class="text-2xl font-medium text-gray-900">Dashboard</h1>

            @livewire('dashboard.general-metrics')

            @livewire('dashboard.billing-metrics')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="">
                    @livewire('dashboard.durations-chart')
                </div>
                <div class="">
                    @livewire('dashboard.video-view-chart')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
