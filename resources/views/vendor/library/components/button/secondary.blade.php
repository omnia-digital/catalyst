@props([
    'size' => 'px-4 py-2'
])

@php
    $class = $size . ' inline-flex items-center justify-center border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500';
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $class]) }}>
    {{ $slot }}
</button>
