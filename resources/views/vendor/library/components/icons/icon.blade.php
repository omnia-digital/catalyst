@props([
    'name' => 'name',
    'size' => 'w-6 h-6',
    'color' => '',
    'class' => '',
])

@if(Str::contains($name,'heroicon'))
    <x-dynamic-component
            :component="$name"
            class="flex-shrink-0 {{ $size }} {{ $color }} {{ $class }} "
            aria-hidden="true"
    />
@else
    <i class="{{ $name }} flex-shrink-0 {{ $size }} {{ $color }} {{ $class }}"></i>
@endif
