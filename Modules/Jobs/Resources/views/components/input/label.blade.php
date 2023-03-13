@props([
'value',
'for' => false
])

<label
    for="{{ $for ? $for : \Illuminate\Support\Str::kebab($value) }}"
    {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-gray-700']) }}
>
    {{ $value ?? $slot ?? null }}
</label>
