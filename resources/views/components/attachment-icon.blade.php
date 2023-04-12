@props([
    'for' => null
])

@php
    $icon = match ($for) {
        'image/jpeg' => 'tni-jpg',
        'image/png' => 'tni-png',
        'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'tni-doc',
        'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'tni-ppt',
        'application/pdf' => 'tni-pdf',
        'youtube.com' => 'tni-youtube',
        default => 'heroicon-s-paper-clip'
    };
    $color = match($for) {
        'image/jpeg' => 'green-400',
        'image/png' => 'purple-500',
        'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'blue-400',
        'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'yellow-500',
        'application/pdf', 'youtube.com' => 'red-400',
        default => 'gray-400'
    }
@endphp

<x-dynamic-component :component="$icon" :class="'flex-shrink-0 h-6 w-6 ' . 'text-'.$color"/>
