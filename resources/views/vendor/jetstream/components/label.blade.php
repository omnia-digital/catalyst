@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-color-dark']) }}>
    {{ $value ?? $slot }}
</label>
