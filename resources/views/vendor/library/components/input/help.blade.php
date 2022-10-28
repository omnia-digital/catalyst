@props(['value'])

<p {{ $attributes->merge(['class' => 'mt-2 text-sm text-base-text-color']) }}>
    {{ $value ?? $slot }}
</p>
