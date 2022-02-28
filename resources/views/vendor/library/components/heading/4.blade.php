@props([
    'boldClass' => 'font-medium'
])

@php
    $class = 'text-base leading-6 text-gray-900 ' . $boldClass;
@endphp

<h3 {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</h3>
