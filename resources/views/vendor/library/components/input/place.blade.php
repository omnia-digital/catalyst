@props([
    'placeholder' => 'Location'
])

<div
        x-on:click.away="listShow = false"
        x-data="{
            error: '',

            listShow: false,

            predictions: [],

            selected: null,

            isSelected(index) {
                return parseInt(index) === this.selected;
            },

            selectNext() {
                if (this.selected === null || this.selected >= this.predictions.length - 1) {
                    this.selected = 0;
                    return;
                }

                this.selected = this.selected + 1;
            },

            selectPrevious() {
                if (this.selected === null || this.selected <= 0) {
                    this.selected = this.predictions.length - 1;
                    return;
                }

                this.selected = this.selected - 1;
            },

            selectItem(index) {
                this.selected = index;
            },

            deselectItem() {
                this.selected = null;
            },

            submit() {
                let item = this.predictions[this.selected];

                this.$refs.searchInput.value = item.description;
                this.listShow = false;

                this.$wire.set('placeId', item.place_id);
            },

            getPredictions(e) {
                let searchQuery = e.target.value;

                this.error = '';

                if (!searchQuery) {
                    return;
                }

                this.$wire
                    .searchPlace(searchQuery)
                    .then(result => {
                        if (result.status !== 'OK' && result.status  !== 'ZERO_RESULTS') {
                            this.error = result.error_message;
                            return;
                        }

                        this.predictions = result.predictions;
                        this.selected = null;

                        if (result.predictions.length > 0) {
                            this.listShow = true;
                        }
                    });
            }
        }"
        wire:ignore
>
    <div class="relative">
        <x-library::input.text
                x-ref="searchInput"
                x-on:input.change.debounce.500ms="getPredictions"
                x-on:keydown.arrow-down.stop.prevent="() => {
                    listShow = true;
                    $refs.listbox.focus();
                    selectNext();
                }"
                x-on:keydown.arrow-up.stop.prevent="() => {
                    listShow = true;
                    $refs.listbox.focus();
                    selectPrevious();
                }"
                x-on:keydown.escape="listShow = false"
                x-on:focus="() => {
                    if (predictions.length > 0) {
                        listShow = true;
                    }
                }"
                placeholder="{{ $placeholder }}"/>

        <p class="text-sm text-red-600" x-show="error.length > 0" x-text="error"></p>

        <ul
                x-show="listShow"
                x-ref="listbox"
                x-transition
                x-on:keydown.arrow-down.stop.prevent="() => selectNext()"
                x-on:keydown.arrow-up.stop.prevent="() => selectPrevious()"
                x-on:keydown.enter.stop.prevent="submit"
                x-on:keydown.space.stop.prevent="submit"
                x-on:keydown.escape="listShow = false"
                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                tabindex="-1"
                role="listbox"
                style="display: none"
        >
            <!--
              Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

              Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
            -->
            <template x-for="(prediction, index) in predictions" :key="prediction.place_id">
                <li
                        x-on:mouseenter.stop.prevent="selectItem(index)"
                        x-on:mouseleave.stop.prevent="deselectItem"
                        x-on:click.stop.prevent="submit"
                        x-bind:class="isSelected(index) ? 'text-white bg-indigo-600' : 'text-gray-900'"
                        class="cursor-pointer select-none relative py-2 pl-3 pr-9" role="option"
                >
                    <span
                            x-bind:class="isSelected(index) ? 'font-semibold' : 'font-normal'"
                            class="block truncate"
                            x-text="prediction.description"></span>
                </li>
            </template>
        </ul>
    </div>
</div>
