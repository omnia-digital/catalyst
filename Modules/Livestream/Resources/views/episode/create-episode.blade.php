<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-4 mb-6">
            <x-input.label value="Title" />
            <x-input.text id="title" wire:model.defer="title" placeholder="Title" />
            <x-jet-input-error for="title" class="mt-2" />
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="flex-1 flex min-w-0">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                        Upload Video
                    </h1>
                    <x-input.toggle class="ml-4" wire:model="hasMedia" />
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-1 flex items-stretch overflow-hidden">
                <main class="flex-1 overflow-y-auto">
                    <div class="p-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
                        @if ($hasMedia)
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-500 text-sm font-medium">From URL</span>
                            <x-input.toggle wire:model="isUpload" />
                            <span class="text-gray-500 text-sm font-medium">Upload</span>
                        </div>
                        <div>
                            @if ($isUpload && $hasMedia)
                            <div class="mt-4">
                                <x-input.mux-uploader />
                            </div>
                            @elseif ($hasMedia)
                            <div class="mt-4">
                                <x-input.label value="From URL" />
                                <x-input.text id="from-url" wire:model.defer="url" placeholder="From URL" />
                                <x-jet-input-error for="url" class="mt-2" />
                            </div>
                            @endif
                        </div>
                        @endif

                        <div>
                            <div class="flex justify-end pt-4">
                                @if (!$isUpload)
                                <x-jet-button wire:click="createEpisodeFromUrl" wire:loading.attr="disabled">
                                    Create Episode
                                </x-jet-button>
                                @endif
                                @if (!$hasMedia)
                                <x-jet-button wire:click="createEpisode" wire:loading.attr="disabled">
                                    Create Episode
                                </x-jet-button>
                                @endif
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>