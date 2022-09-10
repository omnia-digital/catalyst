@props(['active'])

@php
    $classes = 'text-xs ';

    $classes .= ($active ?? false)
                ? 'bg-main-nav-active-bg-color px-2 py-1 rounded-lg inline-flex items-center font-bold text-main-nav-active-text-color focus:outline-none focus:bg-main-nav-active-bg-color transition uppercase'
                : 'px-2 py-1 inline-flex items-center rounded-lg font-bold text-main-nav-text-color hover:text-main-nav-hover-text-color hover:bg-main-nav-hover-bg-color focus:outline-none focus:text-main-nav-hover-text-color focus:bg-main-nav-hover-bg-color
                transition uppercase';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
