@props([
    'loop' => null
])

@php $class = $loop?->index % 2 ? 'bg-gray-50' : 'bg-white'; @endphp

<tr {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</tr>
