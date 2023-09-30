@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

<header class="fi-simple-header">
    @if ($logo)
        <div class="mb-4 flex justify-center">
            <x-filament-panels::logo/>
        </div>
    @endif

    @if (filled($heading))
        <h1
                class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950"
        >
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p
                class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500"
        >
            {{ $subheading }}
        </p>
    @endif
</header>
