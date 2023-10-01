@props([
    'value',
    'title' => null,
    'description'
])

<label
        x-data="{
            selectedItem: @entangle($attributes->wire('model')).live,
            currentItem: '{{ $value }}',
            isActive: false,
            setActive() {
                this.isActive = this.selectedItem === this.currentItem;
            },
            setSelectedItem() {
                this.selectedItem = this.currentItem;
            }
        }"
        x-init="() => {
            setActive();

            $watch('selectedItem', () => setActive());
        }"
        x-on:click.prevent.stop="setSelectedItem"
        x-bind:class="{'border-transparent ring-2 ring-blue-500': isActive, 'border-gray-300': !isActive}"
        x-id="['radio-card', 'radio-card-description']"
        {{ $attributes->class(['relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none']) }}
        {{ $attributes->wire('key') }}
>
    <input
            {{ $attributes->wire('model') }}
            type="radio"
            class="sr-only"
            x-bind:aria-labelledby="$id('radio-card')"
            x-bind:aria-describedby="$id('radio-card-description')"
    >
    <div class="flex-1 flex">
        <div class="flex flex-col">
            <div x-bind:id="$id('radio-card')" class="block text-sm font-medium text-gray-900">
                {{ $title ?? Str::headline($value) }}
            </div>
            <div x-bind:id="$id('radio-card-description')" {{ isset($description) ? $description->attributes->class(['mt-1 text-sm text-gray-500']) : '' }}>
                {{ $description ?? null }}
            </div>
        </div>
    </div>
    <x-heroicon-s-check-circle x-show="isActive" class="h-5 w-5 text-blue-600" style="display: none"/>
    <div x-bind:class="{'border border-blue-500': isActive, 'border-2 border-transparent': !isActive}"
         class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"></div>
</label>
