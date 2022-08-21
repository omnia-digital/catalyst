@props([
    'boldClass' => 'font-medium'
])

@php
    $class = 'text-2xl leading-6 text-heading-default-color ' . $boldClass;
@endphp

<h2 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h2>
