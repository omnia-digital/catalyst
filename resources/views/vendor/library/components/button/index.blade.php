@props([
    'name' => 'name',
    'size' => '',
    'bgColor' => 'secondary',
    'bgColorHover' => 'secondary-dark',
    'textColor' => 'text-white-text-color',
    'textSize' => 'text-sm',
    'boldClass' => 'font-medium',
    'rounded' => 'rounded-md',
    'border' => 'border border-transparent',
    'px' => 'px-4',
    'py' => 'py-2',
    'shadow' => 'shadow-sm',
    'class' => '',
])

@php
    $classString = 'inline-flex items-center justify-center focus:outline-none ';
    if ($class) {
        $classString .= $class . ' ';
    }
    $classString .= 'bg-'.$bgColor . ' ';
    $classString .= 'hover:bg-'.$bgColorHover . ' ';
    $classString .= $textColor . ' ';
    $classString .= $textSize . ' ';
    $classString .= $boldClass . ' ';
    $classString .= $rounded . ' ';
    $classString .= $border . ' ';
    $classString .= $px . ' ';
    $classString .= $py . ' ';
    $classString .= $shadow . ' ';
    $classString .= $size . ' ';

@endphp

<button wire:loading.attr="disabled"
        wire:loading.class="bg-neutral-dark cursor-not-allowed"
        wire:loading.class.remove="bg-{{$bgColor}} hover:bg-{{ $bgColorHover }} focus:ring-{{$bgColor}} text"
        {{ $attributes->merge(['class' => $classString, 'type' => 'button']) }}
>
    <div>
        <span wire:loading {{ $attributes->only('wire:target') }}>Loading...</span>
        <span wire:loading.remove {{ $attributes->only('wire:target') }}>{{ $slot ?? 'Submit' }}</span>
    </div>
</button>
