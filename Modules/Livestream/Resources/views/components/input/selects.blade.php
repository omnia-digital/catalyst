@props([
'placeholder' => 'Type to search',
'options' => [],
'max' => false
])

<div
    x-data="{
        selectedItems: @entangle($attributes->wire('model')),

        options: {{ \Illuminate\Support\Js::from($options) }},

        filteredOptions: [],

        show: false,

        query: '',

        max: '{{ $max }}',

        getSelectedLabel(key) {
            return this.options[key];
        },

        isSelected(key) {
            return this.selectedItems.find((item) => item == key) !== undefined;
        },

        isSearching() {
            return this.query.length > 0;
        },

        remove(key) {
            const index = this.selectedItems.findIndex((item) => item == key);

            if (index !== undefined) {
                this.selectedItems.splice(index, 1);
            }
        },

        add(key) {
            // Remove if already selected
            if (this.isSelected(key)) {
                this.remove(key);
            }
            else {
                // Do not add if reach max.
                if (this.max != false && this.selectedItems.length >= this.max) {
                    return;
                }

                this.selectedItems.push(key);
            }
        },

        async search() {
            let queryInLowerCase = this.query.toLowerCase();
            let filtered = {};

            await Object.entries(this.options).forEach(item => {
                if (item[1].toLowerCase().indexOf(queryInLowerCase) > -1) {
                    filtered[item[0]] = item[1];
                }
            });

            this.filteredOptions = filtered;
        }
    }"
    x-init="() => {
        $watch('query', value => {
            // Show the dropdown if it is closed when typing.
            if (!show && isSearching()) show = true;

            // Searching by query
            search();
        });
    }"
    class="w-full flex flex-col items-center"
>
    <div class="w-full">
        <div class="flex flex-col items-center relative">
            <!-- Selected values + input -->
            <div wire:ignore class="w-full">
                <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
                    <div class="flex flex-auto flex-wrap">
                        <!-- Selected -->
                        <template x-for="selectedItem in selectedItems" :key="selectedItem">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-blue-700 bg-blue-100 border border-blue-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial" x-text="getSelectedLabel(selectedItem)"></div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div x-on:click="remove(selectedItem)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-blue-400 rounded-full w-4 h-4 ml-2">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Input -->
                        <div class="flex-1">
                            <input
                                x-on:click="show = true"
                                x-model="query"
                                placeholder="{{ $placeholder }}"
                                class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
                        </div>
                    </div>
                    <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200">
                        <button x-on:click.prevent="show = !show" class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>

                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down w-4 h-4">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dropdown -->
            <div
                x-show="show"
                x-on:click.away="show = false"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="absolute shadow top-full bg-white z-40 w-full lef-0 rounded max-h-64 overflow-y-auto"
                style="display:none;"
            >
                <div class="flex flex-col w-full">
                    <template x-for="option in Object.entries(isSearching() ? filteredOptions : options)" :key="option[0]">
                        <div
                            x-on:click="add(option[0])"
                            class="cursor-pointer w-full border-gray-100 border-b hover:bg-blue-100"
                        >
                            <div
                                class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative"
                                x-bind:class="{ 'border-blue-600': isSelected(option[0]), 'hover:border-blue-100': !isSelected(option[0]) }"
                            >
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6" x-text="option[1]"></div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
