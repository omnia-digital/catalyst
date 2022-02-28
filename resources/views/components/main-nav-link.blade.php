@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-primary px-2 py-1 rounded-lg inline-flex items-center text-sm font-bold text-white focus:outline-none focus:bg-primary transition uppercase'
            : 'px-2 py-1 inline-flex items-center rounded-lg text-sm font-bold text-gray-500 hover:text-white hover:bg-primary focus:outline-none focus:text-white focus:bg-primary
            transition uppercase';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
