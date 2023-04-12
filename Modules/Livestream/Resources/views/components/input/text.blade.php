@props([
    'type' => 'text'
])

<input type="{{ $type }}" {{ $attributes->merge(['class' => 'block w-full shadow-sm focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md']) }}>
