@props([
    'sortable' => false,
    'direction' => null,
])

<th scope="col" {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider']) }}>
    @if ($sortable !== false)
        <button class="flex items-center space-x-1 group focus:outline-none">
            <span>{{ $slot }}</span>

            <span>
                @if ($direction === 'asc')
                    <x-heroicon-o-chevron-up class="w-3 h-3"/>
                @elseif ($direction === 'desc')
                    <x-heroicon-o-chevron-down class="w-3 h-3"/>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>
