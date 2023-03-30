@props([
    'colspan' => 99,
])

<x-table.cell :colspan="$colspan">{{ $slot }}</x-table.cell>
