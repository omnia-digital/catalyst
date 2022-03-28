@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-secondary-light text-sm font-medium leading-5 text-color-dark focus:outline-none focus:border-secondary-dark transition'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-color-base hover:text-color-dark hover:border-gray-300 focus:outline-none focus:text-color-dark focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
