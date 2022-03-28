@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-secondary-light text-color-base font-medium text-secondary-dark bg-secondary-light focus:outline-none focus:text-secondary-dark
            focus:bg-secondary-light focus:border-secondary-dark transition'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-color-base font-medium text-color-base hover:text-color-dark hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-color-dark focus:bg-gray-50 focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
