@props([
    'title',
    'isActive' => null
])

@php
    if (str_contains($isActive, ',')) {
        list($isActive, $opts) = array_map('trim', explode(',', $isActive));
    }
@endphp

<button
    x-data
    x-tooltip="{{ $title }}"
    x-bind:class="{ 'bg-secondary text-white': isActive({{ $isActive ?? "'false'" }}, {{ $opts ?? '{}' }}, updatedAt) }"
    {{ $attributes->merge(['class' => 'hover:bg-secondary-dark hover:text-white p-1 rounded-lg']) }}
>
    {{ $slot }}
</button>
