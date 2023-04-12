@props([
    'to' => '#',
    'size' => 'py-2 px-4',
    'secondary' => false,
])

@php
    $primaryButton = 'flex-1 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none inline-block';
    $secondaryButton = 'flex-1 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 inline-block';
    $class = $size . ' ' . ($secondary === false ? $primaryButton : $secondaryButton);
@endphp

<a
    href="{{ $to }}"
    {{ $attributes->merge(['class' => $class]) }}
>
    {{ $slot }}
</a>
