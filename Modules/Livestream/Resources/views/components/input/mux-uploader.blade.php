@props([
    'id' => uniqid()
])

<div
        wire:ignore
        x-data="{
        filepond: null,

        uploadUrl: null,

        uploadId: null,

        newEpisodeId: null,

        upload: null,

        baseUrl: '{{ Str::finish(config('app.url'), '/') . 'episodes/' }}'
    }"
        x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);

        filepond = FilePond.create($refs['{{ $id }}']);
        filepond.setOptions({
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $wire.createMuxUploader().then(uploader => {
                         uploadUrl = uploader.url;
                         uploadId = uploader.id

                         // Create episode
                         $wire.createEpisodeByUpload(title.value || file.name, uploadId).then(id => {
                            newEpisodeId = id;
                         });

                         upload = UpChunk.createUpload({
                            endpoint: uploadUrl,
                            file: file,
                            chunkSize: 5120, // Uploads the file in ~5mb chunks
                        });

                        upload.on('progress', muxProgress => {
                            progress(true, muxProgress.detail, 100);

                            // Cannot call load method on success event because of asynchronous.
                            if (muxProgress.detail === 100) {
                                load(uploadId);
                            }
                        });

                        upload.on('success', response => {
                            if (newEpisodeId) {
                                window.location.replace(baseUrl + newEpisodeId);
                            }
                        });
                    });
                },
{{--                revert: (filename, load) => {--}}
{{--                    upload.abort();--}}

{{--                    $wire.deleteEpisode(uploadId);--}}

{{--                    delete upload;--}}
{{--                },--}}
            },
        });
    "
>
    <input type="file" x-ref="{{ $id }}" style="display: none;">
</div>

@once
    @push('scripts')
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script src="https://unpkg.com/@mux/upchunk@2"></script>
    @endpush

    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
              rel="stylesheet">
    @endpush
@endonce
