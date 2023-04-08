@props(['value'])

<p class="mt-2 text-sm text-gray-500">
    {{ $value ?? $slot }}
</p>
