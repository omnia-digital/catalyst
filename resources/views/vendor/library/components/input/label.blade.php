@props([
'value',
'for' => false,
'required' => false
])

<label
    for="{{ $for ?: \Illuminate\Support\Str::kebab($value ?? '') }}"
    {{ $attributes->merge(['class' => 'block mb-1 font-medium text-sm']) }}
>
    {{ $value ?? $slot ?? null }}

    @if ($required)
        <span class="text-red-600 text-sm">*</span>
    @endif
</label>
