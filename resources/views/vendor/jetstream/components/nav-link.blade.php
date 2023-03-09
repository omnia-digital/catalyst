@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary-light text-sm font-medium leading-5 text-dark-text-color focus:outline-none focus:border-primary-dark transition'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-base-text-color hover:text-dark-text-color hover:border-gray-300 focus:outline-none focus:text-dark-text-color focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
