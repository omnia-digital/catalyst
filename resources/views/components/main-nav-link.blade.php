@props(['active'])

@php
    $classes = 'text-xs ';

    $classes .= ($active ?? false)
                ? 'bg-secondary px-2 py-1 rounded-lg inline-flex items-center font-bold text-neutral focus:outline-none focus:bg-secondary transition uppercase'
                : 'px-2 py-1 inline-flex items-center rounded-lg font-bold text-base-text-color hover:text-neutral hover:bg-secondary focus:outline-none focus:text-neutral focus:bg-secondary
                transition uppercase';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
