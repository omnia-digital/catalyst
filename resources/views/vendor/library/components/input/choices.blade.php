@props([
    'multiple' => false,
    'options' => []
])

@php
    // Options prop doesn't have the right format.
    if (count($options) === count($options, COUNT_RECURSIVE)) {
        $options = collect($options)
            ->map(fn($value, $key) => ['value' => $key, 'label' => $value])
            ->all();
    }
@endphp

<div
    wire:ignore
    x-data="{
        multiple: '{{ $multiple }}' == true,
        value: @entangle($attributes->wire('model')),
        options: {{ \Illuminate\Support\Js::from($options) }},
        init() {
            this.$nextTick(() => {
                let choices = new Choices(this.$refs.select)

                let refreshChoices = () => {
                    let selection = this.multiple ? this.value : [this.value]

                    choices.clearStore()
                    choices.setChoices(this.options.map(({ value, label }) => ({
                        value,
                        label,
                        selected: selection.includes(value),
                    })))
                }

                refreshChoices()

                this.$refs.select.addEventListener('change', () => {
                    this.value = choices.getValue(true)
                })

                this.$watch('value', () => refreshChoices())
                this.$watch('options', () => refreshChoices())
            })
        }
    }"
>
    <select x-ref="select" :multiple="multiple"></select>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @endpush
@endonce
