@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-secondary-light text-base-text-color font-medium text-secondary-dark bg-secondary-light focus:outline-none focus:text-secondary-dark
            focus:bg-secondary-light focus:border-secondary-dark transition'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base-text-color font-medium text-base-text-color hover:text-dark-text-color hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-dark-text-color focus:bg-gray-50 focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
