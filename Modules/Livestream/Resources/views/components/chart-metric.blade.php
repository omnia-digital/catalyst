@props([
    'name',
    'value',
    'text',
    'previousValue' => false,
    'color'
])

<div
        x-data="{
            showDataset: localStorage.getItem('{{ $name }}') === null ? true : localStorage.getItem('{{ $name }}') === 'true',

            toggleChart() {
                this.showDataset = !this.showDataset;

                localStorage.setItem('{{ $name }}', this.showDataset);

                $dispatch('toggle-chart', '{{ $name }}')
            }
        }"
        x-on:click="toggleChart"
        {{ $attributes->merge(['class' => 'px-8 py-4 w-1/2 lg:w-auto hover:border-t-4 hover:border-blue-500 cursor-pointer']) }}
>
    <div class="flex items-center text-xs font-bold tracking-wide text-gray-500 uppercase dark:text-gray-400 whitespace-nowrap">
        <span>{{ $name }}</span>
        <div x-show="showDataset" class="w-2 h-2 rounded-full ml-2" style="background-color: {{ $color }}"></div>
    </div>
    <div class="flex items-center justify-between my-1 whitespace-nowrap">
        <b class="mr-4 text-xl md:text-2xl dark:text-gray-100" tooltip="12,403 unique visitors">
            {{ $text }}
        </b>

        @if (is_string($value) || is_string($previousValue))
            {{-- Do nothing if any of the values is a string --}}
        @elseif ($value != 0 && $previousValue !== false)

            <span class="text-xs dark:text-gray-100">
                <span class="{{ $value < $previousValue ? 'text-red-400' : 'text-green-400' }} font-bold">{{ $value < $previousValue ? '↓' : '↑' }}</span>
                {{ round((abs($value - $previousValue)) / $value * 100, 2) }}%
            </span>
        @endif
    </div>
</div>
