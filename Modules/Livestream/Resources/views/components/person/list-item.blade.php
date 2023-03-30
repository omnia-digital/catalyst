@props([
    'selected' => false,
    'person'
])

@php
    $class = $selected ? 'ring-2 ring-offset-2 ring-blue-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-blue-500';
    $class .= ' col-span-1 flex shadow-sm rounded-md cursor-pointer';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    @if ($person?->photo)
        <div class="group block w-1/3 aspect-w-10 aspect-h-2 rounded-l-md bg-gray-100 overflow-hidden relative">
            <img class="{{ $selected ? '' : 'group-hover:opacity-75' }} object-cover pointer-events-none" src="{{ $person->photo }}" alt="{{ $person->name }}">
        </div>
    @endif
    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md">
        <div class="px-4 py-2 sm:px-6 w-full">
            <div class="flex items-center justify-between">
                <p class="font-medium text-blue-600 truncate">
                    {{ Str::limit($person->name, 255) }}
                </p>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                    <x-heroicon-s-calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    <x-timezone :for="$person->created_at"/>
                </div>
            </div>
        </div>
    </div>
</li>
