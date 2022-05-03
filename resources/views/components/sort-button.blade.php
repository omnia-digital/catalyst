@props([
    'key',
    'orderBy',
    'sortDesc'
])
@php
    $selected = ($orderBy === $key);
@endphp
<a
    wire:click.prevent="sortBy('{{ $key }}')"
    href="#"
    aria-current="page"
    class="{{ $selected ? 'text-secondary' : 'text-base-text-color hover:text-dark-text-color' }} whitespace-nowrap my-2 px-1 font-medium text-sm"
>
    <span class="flex">
        {{ $slot }}
        <x-heroicon-o-sort-ascending class="w-3 {{ ($selected && !$sortDesc) ? 'text-dark-text-color' : 'text-gray-400' }}" />
        <x-heroicon-o-sort-descending class="w-3 {{ ($selected && $sortDesc) ? 'text-dark-text-color' : 'text-gray-400' }}" />
    </span>
</a>
