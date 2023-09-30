<div
        x-data="{
        show: false,

        selectTime(time) {
            this.show = false;

            $wire.call('selectTime', time);
        }
    }"
        class="relative inline-block text-left"
>
    <div>
        <button x-on:click="show = true" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
                id="menu-button" aria-expanded="true" aria-haspopup="true">
            {{ $this->timeFilters[$this->selectedTime] }}
            <x-heroicon-s-chevron-down class="-mr-1 ml-2 h-5 w-5"/>
        </button>
    </div>

    <div
            x-show="show"
            x-on:click.away="show = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50"
            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
            style="display: none;"
    >
        <div class="py-1" role="none">
            @foreach ($this->timeFilters as $key => $timeFilter)
                <a
                        x-on:click.prevent="selectTime('{{ $key }}')"
                        wire:key="time-filter-{{ $loop->index }}"
                        href="#"
                        class="{{ $this->selectedTime === $key ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }} block px-4 py-2 text-sm"
                        role="menuitem" tabindex="-1" id="menu-item-{{ $loop->index }}"
                >
                    {{ $timeFilter }}
                </a>
            @endforeach
        </div>
    </div>
</div>
