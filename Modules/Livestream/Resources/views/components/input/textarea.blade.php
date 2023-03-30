@props([
    'rows' => 3
])

<textarea
    rows="{{ $rows }}"
    {{ $attributes->merge(['class' => 'shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 border border-gray-300 rounded-md']) }}></textarea>
