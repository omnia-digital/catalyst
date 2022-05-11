@props([
    'key',
    'orderBy',
    'sortDesc'
])
@php
    $selected = ($orderBy === $key);
@endphp
<a
    wire:click.prevent.stop="sortBy('{{ $key }}')"
    href="#"
    aria-current="page"
    class="{{ $selected ? 'text-secondary' : 'text-base-text-color hover:text-dark-text-color' }} whitespace-nowrap my-2 px-1 font-medium text-sm"
>
    <span class="flex">
        {{ $slot }}
        @if ($selected && !$sortDesc)
            <x-heroicon-s-arrow-narrow-up class="w-3 text-dark-text-color" wire:click.prevent="$toggle('sortDesc')" />
        @else
            <x-heroicon-s-arrow-narrow-down class="w-3 text-dark-text-color" wire:click.prevent="$toggle('sortDesc')" />
        @endif
    </span>
</a>
