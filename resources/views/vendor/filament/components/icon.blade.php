@php use Filament\Support\Facades\FilamentIcon; @endphp
@php use Illuminate\Contracts\Support\Htmlable; @endphp
@props([
    'alias' => null,
    'class' => '',
    'icon' => null,
])

@php
    $icon = ($alias ? FilamentIcon::resolve($alias) : null) ?: $icon;
@endphp

@if ($icon instanceof Htmlable)
    <div {{ $attributes->class($class) }}>
        {{ $icon ?? $slot }}
    </div>
@elseif (str_contains($icon, '/'))
    <img
            {{
                $attributes
                    ->merge(['src' => $icon])
                    ->class($class)
            }}
    />
@else
    @svg(
        $icon,
        $class,
        array_filter($attributes->getAttributes()),
    )
@endif
