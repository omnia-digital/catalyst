<x-base-layout>
    <div class="min-h-screen bg-gray-50 flex overflow-hidden">
        <!-- Narrow sidebar -->
        @include('partials.sidebar')

        <!-- Mobile menu - Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        @include('partials.mobile-menu')

        <!-- Content area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('partials.header')
            @include('partials.trial-header')
            {{ $slot }}
        </div>
    </div>
</x-base-layout>
