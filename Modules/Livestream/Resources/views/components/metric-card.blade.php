@props([
    'name',
    'value'
])

<div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
    <dt class="text-sm font-medium text-gray-500 truncate">
        {{ $name }}
    </dt>
    <dd class="mt-1 text-3xl font-semibold text-gray-900">
        {{ $value }}
    </dd>
</div>
