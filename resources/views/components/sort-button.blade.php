@props([
    'key',
    'orderBy'
])

<a
    wire:click.prevent="sortBy('{{ $key }}')"
    href="#"
    aria-current="page"
    class="{{ $orderBy === $key ? 'border-secondary text-secondary' : 'border-transparent text-color-base hover:text-color-dark hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
>
    {{ $slot }}
</a>
