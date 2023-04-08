<div>
    <!-- Sidebar -->
    <aside class="hidden w-96 h-full bg-white p-8 border-l border-gray-200 overflow-y-auto lg:block">
        @if ($massAttachmentUpload)
            @livewire('episode.mass-attachment-upload-panel')
        @elseif (!$multiSelectMode)
            @livewire('episode.episode-info-panel', ['episodeId' => $selectedEpisode])
        @else
            <x-multi-select-panel :episodes="\App\Models\Episode::whereIn('id', $selectedIDs)->get()" :episodesCount="sizeof($selectedIDs)" />
        @endif
    </aside>

    <!-- Slide over - Only for mobile -->
    <div class="lg:hidden">
        <x-slide-over eventSlideOverClosed="episode-deselected" :show="!empty($selectedEpisode)" disableCloseOnClickAway>
            @livewire('episode.episode-info-panel', ['episodeId' => $selectedEpisode])
        </x-slide-over>
        <x-slide-up :show="$multiSelectMode">
            <x-slot name="title">Selected Episodes ({{ sizeof($selectedIDs) }})</x-slot>
            <div class="p-4 pb-0">
                <ul class="h-28 overflow-y-auto">
                    @foreach (\App\Models\Episode::whereIn('id', $selectedIDs)->get() as $key => $episode)
                        <li class="flex justify-between items-center hover:text-red-500">
                            <span>{{ $episode->title }}</span>
                            <x-heroicon-s-x wire:click="multiDeselect('{{ $episode->id }}')" class="w-4 h-4 flex-shrink-0 text-gray-400 hover:text-red-600 cursor-pointer" />
                        </li>
                    @endforeach
                </ul>
                <div class="pt-3 border-t border-gray-500">
                    <div class="mt-3">
                        <livewire:episode.delete-multiple-episodes :episodeIDs="$selectedIDs"/>
                    </div>
                </div>
            </div>
        </x-slide-up>
    </div>
</div>

@once
    @push('scripts')
        <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

        <script src="https://cdn.jwplayer.com/libraries/Wq6HOAmw.js"></script>
    @endpush

    @push('styles')
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet">
    @endpush
@endonce
