@props([
'value',
'for' => false,
'required' => false,
'color' => 'text-neutral-dark',
'class' => '',
])

@php
    $class = 'text-sm font-medium ' . $class;
@endphp

<label
    for="{{ $for ?: \Illuminate\Support\Str::kebab($value ?? '') }}"
    {{ $attributes->merge(['class' => $class]) }}
>
    {{ $value ?? $slot ?? null }}

    @if ($required)
        <span class="text-red-600 text-sm">*</span>
    @endif
</label>
