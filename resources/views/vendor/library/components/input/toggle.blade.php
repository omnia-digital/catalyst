@props([
'falseValue' => false,
'trueValue' => true,
'falseBackgroundColor' => 'bg-gray-200',
'trueBackgroundColor' => 'bg-secondary'
])

<button
    x-data="{
        currentValue: @entangle($attributes->wire('model')),

        toggleValue() {
            this.currentValue = this.currentValue == '{{ $falseValue }}' ? '{{ $trueValue }}' : '{{ $falseValue }}';
        }
    }"
    x-bind:aria-pressed="currentValue ? currentValue.toString() : null"
    x-on:click="toggleValue"
    x-bind:class="{ '{{ $trueBackgroundColor }}': currentValue == '{{ $trueValue }}', '{{ $falseBackgroundColor }}': currentValue == '{{ $falseValue }}' }"
    type="button"
    {{ $attributes->merge(['class' => 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary'])->except('wire:model') }}
>
    <span
        aria-hidden="true"
        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-neutral shadow transform ring-0 transition ease-in-out duration-200 translate-x-5"
        x-bind:class="{ 'translate-x-5': currentValue == '{{ $trueValue }}', 'translate-x-0': currentValue == '{{ $falseValue }}' }"></span>
</button>
