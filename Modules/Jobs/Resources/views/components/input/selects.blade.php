@props([
'options' => [],
'disabled' => false,
'max' => false,
'default' => []
])

<div
    x-on:input.stop
    wire:ignore
    {{ $attributes->whereStartsWith('wire:') }}
    x-data="{
        items: JSON.parse('{{ json_encode($options) }}'),

        rawItems: JSON.parse('{{ json_encode($options) }}'),

        selectedValues: JSON.parse('{{ json_encode(array_map(fn($item) => (string) $item, $default)) }}'),

        open: false,

        search: '',

        max: '{{ $max }}',

        addItem: function(value, $dispatch) {
            if (this.selectedValues.length >= this.max) {
                return;
            }

            this.selectedValues.push(value);

            $dispatch('input', this.selectedValues)
        },

        removeItem: function(value, $dispatch) {
            let index = this.selectedValues.indexOf(value);
            this.selectedValues.splice(index, 1);

            $dispatch('input', this.selectedValues)
        }
    }"
    x-init="function() {
        $watch('search', value => {
            if (value.length > 0) {
                let items = {};
                Object.entries(this.rawItems).forEach(item => {
                    if (item[1].toLowerCase().indexOf(value.toLowerCase()) > -1) {
                        items[item[0]] = item[1]
                    }
                })

                this.items = items;
            }
            else {
                this.items = this.rawItems;
            }
       });
    }"
>
    <div class="mb-2">
        <template x-for="value in selectedValues" :key="value">
            <span x-on:click="removeItem(value, $dispatch)"
                  class="bg-green-200 py-1 px-4 text-xs rounded-lg cursor-pointer" x-text="rawItems[value]"></span>
        </template>
    </div>
    <div
        x-on:click.away="open = false"
        class="relative"
    >
        <input
            wire:input.stop
            x-model="search"
            x-on:focus="open = true"
            x-bind:class="{'rounded-b-none': open === true, '': open === false }"
            {{ $attributes->merge(['class' => 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 focus:outline-none '])->except('wire:model') }}
            autocomplete="off"/>
        <ul
            wire:ignore
            x-show="open"
            class="absolute bg-white px-1 top-0 mt-9 rounded-b-md border border-gray-300 w-full z-50 overflow-scroll max-h-40 shadow-lg"
            style="display: none"
        >
            <template x-for="[value, label] in Object.entries(items)" :key="value">
                <li x-show="!selectedValues.includes(value)" class="hover:bg-light-blue-200 p-2 text-sm">
                    <a x-on:click.prevent="addItem(value, $dispatch)" href="#" class="block" x-text="label"></a>
                </li>
            </template>
        </ul>
    </div>
</div>
