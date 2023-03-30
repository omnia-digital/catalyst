@props([
    'name',
    'modelTitle',
    'modelLink' => null
])

<div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
    <dt class="text-sm font-medium text-gray-500 truncate">
        {{ $name }}
    </dt>
    @if($modelTitle)
        <dd class="mt-1 text-3xl font-semibold text-gray-900">
            {{ $modelTitle ?? 'Not enough data' }}
        </dd>
    @else
        <dd class="mt-1 text-lg font-normal text-gray-400">
            Not enough data
        </dt>
    @endif
    @if ($modelLink)
        <a class="text-gray-500 hover:text-gray-800 hover:underline active:text-gray-800 active:underline focus:text-gray-800 focus:underline" href="{{ $modelLink }}" target="_blank">
            <dd class="flex justify-end items-center text-xs">view
                <x-heroicon-o-external-link class="h-3 w-3 ml-1"/>
            </dd>
        </a>
    @endif
</div>
