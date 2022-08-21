@props([
    'boldClass' => 'font-medium'
])

@php
    $class = 'text-lg leading-6 text-heading-default-color ' . $boldClass;
@endphp

<h3 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h3>
