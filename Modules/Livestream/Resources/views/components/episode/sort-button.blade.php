@props([
    'key',
    'orderBy'
])

<a
        wire:click.prevent="sortBy('{{ $key }}')"
        href="#"
        aria-current="page"
        class="{{ $orderBy === $key ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
>
    {{ $slot }}
</a>
