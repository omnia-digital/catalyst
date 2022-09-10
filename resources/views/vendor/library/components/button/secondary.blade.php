@props([
    'size' => 'px-4 py-2'
])

@php
    $class = $size . ' inline-flex items-center justify-center border border-gray-300 shadow-sm text-sm font-medium rounded-md text-dark-text-color bg-neutral hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-secondary';
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $class]) }}>
    {{ $slot }}
</button>
