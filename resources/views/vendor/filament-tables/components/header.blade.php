@php
    use Filament\Support\Enums\Alignment;use Filament\Tables\Actions\HeaderActionsPosition;
@endphp

@props([
    'actions' => [],
    'actionsPosition',
    'description' => null,
    'heading' => null,
])

<div
        {{
            $attributes->class([
                'fi-ta-header flex flex-col justify-start gap-3 p-4 sm:px-6',
                'sm:flex-row sm:items-center sm:justify-between' => $actionsPosition === HeaderActionsPosition::Adaptive,
            ])
        }}
>
    @if ($heading || $description)
        <div class="grid gap-y-1">
            @if ($heading)
                <h3
                        class="fi-ta-header-heading text-base font-semibold leading-6"
                >
                    {{ $heading }}
                </h3>
            @endif

            @if ($description)
                <p
                        class="fi-ta-header-description text-sm text-gray-600"
                >
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif

    @if ($actions)
        <x-filament-tables::actions
                :actions="$actions"
                :alignment="Alignment::Start"
                wrap
        />
    @endif
</div>
