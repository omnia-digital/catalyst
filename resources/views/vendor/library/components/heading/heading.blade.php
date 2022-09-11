@props([
    'heading' => 'h1',
    'textColor' => 'text-heading-default-color',
    'textSize' => 'text-3xl',
    'boldClass' => 'font-medium',
    'class'=> ''
])

@php
    $classString = '';
    $classString = 'py-2 leading-6 hover:cursor-pointer font-extrabold tracking-tight';
    $classString .= $boldClass . ' ';
    $classString .= $textColor . ' ';
    $classString .= $textSize . ' ';
    if ($class) {
        $classString .= $class . ' ';
    }

@endphp

@switch($heading)
    @case('h1')
        <h1 {{ $attributes->merge(['class' => $classString]) }}>
            {{ $slot }}
        </h1>
        @break
    @case('h2')
        <h2 {{ $attributes->merge(['class' => $classString]) }}>
            {{ $slot }}
        </h2>
        @break
    @case('h3')
        <h3 {{ $attributes->merge(['class' => $classString]) }}>
            {{ $slot }}
        </h3>
        @break
    @case('h4')
        <h4 {{ $attributes->merge(['class' => $classString]) }}>
            {{ $slot }}
        </h4>
        @break
@endswitch
