@props([
    'type' => 'button',
    'size' => 'py-2 px-4',
    'secondary' => false,
    'loadingText' => 'Loading...',
    'loading' => false,
    'danger' => false,
])

@php
    $primaryButton = 'flex w-full bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none justify-center';
    $secondaryButton = 'flex w-full bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2
    focus:ring-blue-500 justify-center';
    $class = $size . ' ' . ($secondary === false ? $primaryButton : $secondaryButton);
    $class .= $danger ? ' hover:bg-red-600 hover:text-white' : '';
@endphp

@if ($loading !== false)
    <button
        wire:loading.attr="disabled"
        wire:loading.class.remove="bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:bg-gray-50 bg-white text-gray-700"
        wire:loading.class="bg-gray-500 cursor-not-allowed text-white"
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $class]) }}
    >
        <span wire:loading {{ $attributes->only('wire:target') }}>{{ $loadingText }}</span>
        <span wire:loading.remove {{ $attributes->only('wire:target') }}>{{ $slot }}</span>
    </button>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $class]) }}
    >
        {{ $slot }}
    </button>
@endif
