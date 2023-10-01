<div class="min-h-full bg-neutral md:pl-64 flex flex-col">
    {{--            @livewire('navigation-menu')--}}

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-secondary shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif
</div>
