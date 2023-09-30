<div>
    <!-- Sidebar -->
    <aside class="hidden w-96 h-full bg-white p-8 border-l border-gray-200 rounded-lg overflow-y-auto lg:block min-h-screen">
        <livewire:partials.media-library-details :mediaId="$selectedMedia"/>
    </aside>

    <!-- Slide over - Only for mobile -->
    <div class="lg:hidden">
        <x-slide-over eventSlideOverClosed="media-deselected" :show="!empty($selectedMedia)" disableCloseOnClickAway>
            <livewire:partials.media-library-details :mediaId="$selectedMedia"/>
        </x-slide-over>
    </div>
</div>

@once
    @push('scripts')
        <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    @endpush

    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
              rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css"
              rel="stylesheet">
    @endpush
@endonce
