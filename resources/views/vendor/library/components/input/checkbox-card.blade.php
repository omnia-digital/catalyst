@props([
    'value',
])

<label
        x-data="{
            selectedItems: @entangle($attributes->wire('model')),
            currentItem: '{{ $value }}',
            isActive: false,
            setActive() {
                this.isActive = Object.values(this.selectedItems).includes(this.currentItem);
            },
            setSelectedItems() {
                let selectedItemsArray = Object.values(this.selectedItems);

                if (this.isActive) {
                    const index = selectedItemsArray.indexOf(this.currentItem);

                    if (index > -1) {
                        selectedItemsArray.splice(index, 1);
                    }
                }
                else {
                    selectedItemsArray.push(this.currentItem);
                }

                this.selectedItems = selectedItemsArray;
            }
        }"
        x-init="() => {
            setActive();

            $watch('selectedItems', () => setActive());
        }"
        x-on:click.prevent.stop="setSelectedItems"
        x-bind:class="{'border-transparent ring-2 ring-secondary': isActive, 'border-gray-300': !isActive}"
        x-id="['checkbox-card']"
        {{ $attributes->class(['border rounded-md py-2 px-2 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none']) }}
        {{ $attributes->wire('key') }}
>
    <input
            {{ $attributes->wire('model') }}
            type="checkbox"
            class="sr-only"
            x-bind:aria-labelledby="$id('checkbox-card')"
    >
    <p x-bind:id="$id('checkbox-card')">
        {{ $slot->isNotEmpty() ? $slot : str($value)->headline() }}
    </p>
</label>
