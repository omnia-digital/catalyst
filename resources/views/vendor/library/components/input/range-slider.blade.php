@props([
    'min',
    'max',
    'step',
    'decimals' => 2,
    'prefix' => '',
    'suffix' => '',
    'options' => [],
    'showTextFields' => false,
    'disableTextFields' => false
])

@php
    $options = array_merge([
        'range' => [
            'min' => $min + 0,
            'max' => $max + 0
        ],
        'step' => $step + 0,
        'connect' => true
    ], $options);
@endphp

<div
        x-data="{
            value: @entangle($attributes->wire('model')),
            options: {{ \Illuminate\Support\Js::from($options) }},
            disableTextFields: '{{ $disableTextFields !== false }}' != false,
            inputMin: 0,
            inputMax: 10,
            init() {
                this.inputMin = this.value[0];
                this.inputMax = this.value[1];

                this.options.start = this.value;
                this.options.format = wNumb({
                    decimals: {{ $decimals }},
                    suffix: '{{ $suffix }}',
                    prefix: '{{ $prefix }}'
                });

                let slider = noUiSlider.create(this.$refs.rangeSlider, this.options);

                slider.on('update', (newValue) => {
                    this.value = newValue;
                    this.inputMin = newValue[0];
                    this.inputMax = newValue[1];
                });

                this.$watch(['inputMin', 'inputMax'], (value) => {
                    let min = this.inputMin ? this.inputMin : 0;
                    let max = this.inputMax ? this.inputMax : 0;

                    slider.set([min, max], true, true);
                });
            }
        }"
        class="w-full"
        wire:ignore
>
    <div x-ref="rangeSlider"></div>

    @if ($showTextFields !== false)
        <div class="flex items-center space-x-4 mt-4">
            <x-library::input.text placeholder="Min" x-data="" x-model="inputMin" x-bind:disabled="disableTextFields"/>
            <x-library::input.text placeholder="Max" x-data="" x-model="inputMax" x-bind:disabled="disableTextFields"/>
        </div>
    @endif
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.5.1/dist/nouislider.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/wnumb@1.2.0/wNumb.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/nouislider@15.5.1/dist/nouislider.min.js"></script>
    @endpush
@endonce
