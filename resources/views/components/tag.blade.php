@props([
    'name' => 'tag',
    'bgColor' => 'neutral',
    'textColor' => 'base-text-color',
    'textSize' => '2xs',
    'class' => '',
])
<x-library::tag :bg-color="$bgColor" :text-color="$textColor" :text-size="$textSize"
                class="{{ $class }}">{{ $name }}</x-library::tag>
