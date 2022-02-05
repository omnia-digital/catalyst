<div class="min-h-full bg-gray-100 md:pl-64 flex flex-col">
{{--            @livewire('navigation-menu')--}}

<!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif
</div>
