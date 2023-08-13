<div>
    @if ($episode)
        <div>
            <div class="pb-16 space-y-6">
                <div>
                    <div>
                        @if ($episode->video)
                            <div class="block w-full rounded-lg overflow-hidden">
                                <x-jwplayer :episode="$episode->toPlayer()"/>
                            </div>
                        @else
                            <x-alert.info>Video is processing.</x-alert.info>
                        @endif
                    </div>

                    <div class="mt-4 flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">{{ $episode->title }}</h2>
                            <p class="text-sm font-medium text-gray-500">{{ $episode->formattedDuration }}</p>
                        </div>
                        <button wire:click="showEditModal" type="button" class="ml-4 bg-white rounded-full h-8 w-8 flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <x-heroicon-s-pencil class="h-5 w-5"/>
                            <span class="sr-only">Add description</span>
                        </button>
                    </div>

                    <div class="py-3 flex space-x-2 text-sm font-medium">
                        <dt class="text-gray-500">Published</dt>
                        <dd class="text-gray-900">
                            @if ($episode->is_published)
                                <x-heroicon-s-check-circle class="h-5 w-5 text-green-500"/>
                            @else
                                <x-heroicon-s-x-circle class="h-5 w-5 text-red-500"/>
                            @endif
                        </dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Views</dt>
                        <dd class="text-gray-900">{{ number_format($episode->views) }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Total Downloads</dt>
                        <dd class="text-gray-900">{{ $episode->attachmentDownloads()->count() }}</dd>
                    </div>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Dates</h3>
                    <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Date recorded</dt>
                            <dd class="text-gray-900">{{ $episode->date_recorded->format('M jS, Y') }}</dd>
                        </div>

                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Last modified</dt>
                            <dd class="text-gray-900">
                                <x-timezone :for="$episode->updated_at"/>
                            </dd>
                        </div>

                        @if ($episode->expires_at)
                            <div class="py-3 flex justify-between text-sm font-medium">
                                <dt class="text-gray-500">
                                    @if ($episode->livestreamAccount->isAutoDeletesVideos())
                                        Auto-Deletes
                                    @else
                                        Storage charge starts
                                    @endif
                                </dt>
                                <dd class="text-gray-900">{{ $episode->expires_at->format('M jS, Y') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Details</h3>

                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-sm text-gray-500 italic">{{ $episode->description }}</p>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Main speaker</dt>
                        <dd class="text-gray-900">{{ $episode->mainSpeaker?->name }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Organization</dt>
                        <dd class="text-gray-900">{{ $episode->livestreamAccount->team->name }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Series</dt>
                        <dd class="text-gray-900">{{ $episode->seriesLabels }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Main Passage</dt>
                        <dd class="text-gray-900">{{ $episode->main_passage }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Other Passages</dt>
                        <dd class="text-gray-900">{{ $episode->other_passages }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Topics</dt>
                        <dd class="text-gray-900">{{ $episode->tagsWithType('topic')->implode('name', ',') }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Category</dt>
                        <dd class="text-gray-900">{{ $episode->category?->name }}</dd>
                    </div>
                </div>

                <div>
                    <h3 class="font-medium text-gray-900">Metadata</h3>
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Episode ID</dt>
                        <dd class="text-gray-900">{{ $episode->id }}</dd>
                    </div>

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Video Source Type</dt>
                        <dd class="text-gray-900">{{ $episode->video?->videoSource()->name() }} ({{ $episode->video?->video_source_type_id }})</dd>
                    </div>

                    @if (\Auth::user()->isAdmin() || \Auth::user()->isImpersonating())
                        <div class="py-3 flex justify-between text-sm font-medium">
                            <dt class="text-gray-500">Video Source ID</dt>
                            <dd class="text-gray-900">{{ $episode->video?->video_source_id }}</dd>
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex justify-between">
                        <h3 class="font-medium text-gray-900">Attachments</h3>
                        <button
                                type="button"
                                x-data
                                x-on:click="$wire.emitTo('attachment.upload-attachment-modal', 'uploadAttachmentShow')"
                        >
                            <x-heroicon-s-plus class="w-6 h-6 text-blue-500 hover:text-blue-700"/>
                        </button>
                    </div>
                    @if ($attachments->isNotEmpty() || $staticAttachments->isNotEmpty())
                        <dl class="mt-2 border-t border-b border-gray-200 divide-y divide-gray-200">
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul role="list" class="divide-y divide-gray-200">
                                    @foreach ($attachments as $attachment)
                                        <li class="py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <x-attachment-icon :for="$attachment->mime_type"/>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $attachment->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <div class="flex items-center space-x-2">
                                                    <button wire:click.prevent="downloadAttachment('{{ $attachment->uuid }}')">
                                                        <x-heroicon-o-download class="w-5 h-5 font-medium text-indigo-600 hover:text-indigo-500"/>
                                                    </button>
                                                    <button type="button" wire:click="showDeleteAttachmentModal('{{ $attachment->uuid }}')">
                                                        <x-library::icons.icon name="x-mark" class="w-5 h-5 font-medium text-red-600 hover:text-red-500"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                    @foreach ($staticAttachments as $staticAttachment)
                                        <li class="py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <x-attachment-icon :for="$staticAttachment->mime_type"/>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $staticAttachment->name }}</span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ $staticAttachment->getStaticUrl() }}" target="_blank">
                                                        <x-heroicon-o-external-link class="w-5 h-5 font-medium text-indigo-600 hover:text-indigo-500"/>
                                                    </a>
                                                    <button type="button" wire:click="showDeleteAttachmentModal('{{ $staticAttachment->uuid }}')">
                                                        <x-library::icons.icon name="x-mark" class="w-5 h-5 font-medium text-red-600 hover:text-red-500"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </dl>

                        <x-confirm id="confirm-delete-attachment" submit="deleteAttachment('{{ $deletingAttachment }}')">
                            <x-slot name="title">Delete Attachment</x-slot>
                        </x-confirm>
                    @endif
                </div>

                @if ($episode->video)
                    <div>
                        <x-form.button wire:click="downloadEpisode" wire:target="downloadEpisode" loading loadingText="Downloading...">
                            Download
                        </x-form.button>
                    </div>
                @endif

                <h3 class="text-red-600 font-bold">Danger Zone</h3>
                <div class="grid grid-cols-2 gap-2">
                    <livewire:episode.move-episode :episode="$episode" wire:key="move-episode-{{ now() }}" />
                    <livewire:episode.delete-episode :episode="$episode" wire:key="delete-episode-{{ now() }}" />
                </div>
            </div>

            <!-- Edit modal -->
            @include('episode.partials.edit-episode-modal', ['state' => $state])
        </div>

        <div>
            @livewire('attachment.upload-attachment-modal', ['episode' => $episode], key('upload-attachment-modal-' . now()))
        </div>
    @else
        <div class="p-16">
            <x-heroicon-s-information-circle class="w-8 h-8 text-gray-400 mx-auto mb-2"/>
            <h2 class="font-medium text-gray-400 text-center">Please select an episode to show detail.</h2>
        </div>
    @endif
</div>
