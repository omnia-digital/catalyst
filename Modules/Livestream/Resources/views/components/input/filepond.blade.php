@props([
    'defaultImage' => null,
    'defaultImageName' => null,
    'defaultImageMaxHeight' => 250,
    'defaultImageSimpleMode' => false
])

@php $defaultImageName = $defaultImageName ?: basename($defaultImage ?? '') @endphp

<div
    wire:ignore
    x-data="{
        filepond: null,

        defaultImage: '{{ $defaultImage }}'
    }"
    x-init="
        FilePond.registerPlugin(FilePondPluginFilePoster);
        FilePond.registerPlugin(FilePondPluginImagePreview);

        filepond = FilePond.create($refs['{{ $attributes->wire('model')->value() }}']);

        filepondOption = {
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes->wire('model')->value() }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->wire('model')->value() }}', filename, load)
                }
            }
        };

        @this.on('clearUploadInput', () => {
            filepond.getFiles().length && filepond.removeFiles();
        });

        if (defaultImage) {
            filepondOption['allowFilePoster'] = '{{ $defaultImageSimpleMode === false }}' == 1;
            filepondOption['filePosterMaxHeight'] = '{{ $defaultImageMaxHeight }}';
            filepondOption['files'] = [
                {
                    source: '{{ $defaultImageName }}',

                    options: {
                        type: 'local',

                        metadata: {
                            poster: '{{ $defaultImage }}',
                        },
                    },
                },
            ];
        }

        filepond.setOptions(filepondOption);
    "
>
    <input type="file" x-ref="{{ $attributes->wire('model')->value() }}">
</div>

@once
    @push('scripts')
        <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    @endpush

    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet">
    @endpush
@endonce
