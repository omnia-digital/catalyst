@props([
'id' => uniqid(),
'readonly' => false
])

<div
        x-data="{
            value: @entangle($attributes->wire('model')),
            setValue() { this.$refs['{{ $id }}'].editor.loadHTML(this.value) },
            setEditable() { this.$refs['{{ $id }}'].contentEditable = '{{ $readonly === false ? 'true' : 'false' }}' },
        }"
        x-init="setEditable();"
        x-on:trix-change="$dispatch('input', $event.target.value)"
        x-on:refresh-trix.window="setValue()"
        @trix-file-accept.prevent
        {{ $attributes->merge(['class' => 'rounded-md shadow-sm'])->except('wire:model') }}
        wire:ignore
>
    <input id="{{ $id }}" value="{{ $this->getPropertyValue($attributes->wire('model')->value) }}" type="hidden">
    <trix-editor x-ref="{{ $id }}" input="{{ $id }}"></trix-editor>
</div>

@once
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0-alpha.1/dist/trix.css">

        <style>
            trix-editor h1 {
                font-size: 1.2em;
                font-weight: bold;
                line-height: 1.2;
            }

            trix-editor ul {
                list-style-type: disc;
                padding-left: 2.5rem;
            }

            trix-editor ol {
                list-style-type: decimal;
                padding-left: 2.5rem;
            }

            trix-editor blockquote {
                border: 0 solid #ccc;
                border-left-width: 0.3em;
                margin-left: 0.3em;
                padding-left: 0.6em;
            }

            trix-editor a {
                color: #EF4444;
                text-decoration: underline;
                cursor: pointer;
            }

            .trix-dialogs {
                z-index: 999 !important;
            }

            [data-trix-button-group="file-tools"] {display: none !important;}
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/trix@2.0.0-alpha.1/dist/trix.umd.js"></script>
    @endpush
@endonce
