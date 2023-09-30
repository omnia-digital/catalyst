@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block pl-3 pr-4 py-2 border-l-4 border-primary-light text-base-text-color font-medium text-primary-dark bg-primary-light focus:outline-none focus:text-primary-dark
                focus:bg-primary-light focus:border-primary-dark transition'
                : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base-text-color font-medium text-base-text-color hover:text-dark-text-color hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-dark-text-color focus:bg-gray-50 focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
