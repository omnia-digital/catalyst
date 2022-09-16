@props([
    'name' => 'tag',
    'bgColor' => 'neutral',
    'textColor' => 'base-text-color',
    'textSize' => 'base',
    'class' => '',
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 rounded-lg font-medium uppercase ' . 'bg-'.$bgColor .' '. 'text-'.$textColor .' '. 'text-'.$textSize .' '. $class]) }}>
  {{ $slot }}
</span>
