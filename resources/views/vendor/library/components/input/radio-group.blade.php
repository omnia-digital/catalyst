@props([
    'value',
    'title' => null,
    'description'
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
    x-id="['radio-card', 'radio-card-description']"
    {{ $attributes->class(['relative bg-neutral border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none']) }}
    {{ $attributes->wire('key') }}
>
    <input
        {{ $attributes->wire('model') }}
        type="checkbox"
        class="sr-only"
        x-bind:aria-labelledby="$id('radio-card')"
        x-bind:aria-describedby="$id('radio-card-description')"
    >
    <div class="flex-1 flex">
        <div class="flex flex-col">
            <div x-bind:id="$id('radio-card')" class="block text-sm font-medium text-dark-text-color">
                {{ $title ?? Str::headline($value) }}
            </div>
            <div x-bind:id="$id('radio-card-description')" {{ isset($description) ? $description->attributes->class(['mt-1 text-sm text-base-text-color']) : '' }}>
                {{ $description ?? null }}
            </div>
        </div>
    </div>
    <x-heroicon-s-check-circle x-show="isActive" class="h-5 w-5 text-secondary-dark" style="display: none"/>
    <div x-bind:class="{'border border-secondary': isActive, 'border-2 border-transparent': !isActive}" class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"></div>
</label>
