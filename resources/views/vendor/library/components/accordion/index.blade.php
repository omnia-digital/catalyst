@props([
    'default' => null
])

<div x-data="{ active: '{{ $default }}' }" {{ $attributes->merge(['class' => 'space-y-4']) }}>
    {{ $slot }}
</div>
