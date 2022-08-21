@props([
    'boldClass' => 'font-medium'
])

@php
    $class = 'text-base leading-6 text-dark-text-color ' . $boldClass;
@endphp

<h4 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h4>
