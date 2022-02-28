@props([
'href' => '#',
'secondary' => false,
'size' => 'px-4 py-2'
])

@php
    $class = $secondary
    ? $size . ' inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500'
    : $size . ' inline-flex items-center justify-center border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
