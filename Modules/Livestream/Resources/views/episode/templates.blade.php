<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createEpisodeTemplateModalOpen')" title=" Template" icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>Episode Title</x-table.heading>
                                    <x-table.heading>Episode Description</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($episodeTemplates as $episodeTemplate)
                                    <x-table.row :loop="$loop" wire:key="{{ $episodeTemplate->id }}" class="">
                                        <x-table.cell class="font-medium text-gray-900">
                                            {{ $episodeTemplate->title }}

                                            <span>
                                                @if ($defaultEpisodeTemplateId === $episodeTemplate->id)
                                                    <x-heroicon-s-star
                                                            class="inline-flex items-center w-4 h-4 text-blue-500 ml-2"/>
                                                @endif
                                            </span>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            {{ $episodeTemplate->template['title'] ?? null }}
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            {{ $episodeTemplate->template['description'] ?? null }}
                                        </x-table.cell>
                                        <x-table.cell class="text-right font-medium flex-1 items-center space-x-2">
                                            <x-form.button-link
                                                    :to="route('episode-templates.update', $episodeTemplate)" size="p-2"
                                                    secondary>
                                                <x-heroicon-o-pencil class="w-4 h-4"/>
                                            </x-form.button-link>

                                            @if ($defaultEpisodeTemplateId !== $episodeTemplate->id)
                                                <x-form.button-link
                                                        wire:click="setDefault('{{ $episodeTemplate->id }}')" size="p-2"
                                                        secondary>
                                                    <x-heroicon-o-star class="w-4 h-4"/>
                                                </x-form.button-link>
                                            @endif
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No episode templates
                                                matched the given criteria.</p>
                                            <x-form.button wire:click="$toggle('createEpisodeTemplateModalOpen')"
                                                           secondary size="py-1 px-4">
                                                Create Episode Templates
                                            </x-form.button>
                                        </div>
                                    </x-table.empty>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="createEpisodeTemplateModalOpen">
        <x-slot name="title">Create Episode Template</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Episode Title" required/>
                <x-input.text id="episode-title" wire:model="title" placeholder="{{ __('Episode Title') }}"/>
                <x-input-error for="title" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Episode Description" required/>
                <x-input.textarea id="episode-description" wire:model="description"
                                  placeholder="{{ __('Episode Description') }}"/>
                <x-input-error for="description" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Episode Thumbnail"/>
                <x-input.filepond id="episode-thumbnail" wire:model="thumbnail"/>
                <x-input-error for="thumbnail" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Series"/>
                <x-input.selects wire:model="selectedSeries" id="series" :options="$series"/>
                <x-input-error for="selectedSeries" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Topics"/>
                <x-input.text id="topics" wire:model="topics" placeholder="Topics"/>
                <x-input-error for="topics" class="mt-2"/>
                <x-input.help>Each topic will be seperated by a comma (,).</x-input.help>
            </div>
            <div class="mt-4">
                <x-episode-template-shortcodes/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('createEpisodeTemplateModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="createEpisodeTemplate" wire:loading.attr="disabled">
                {{ __('Create Episode Template') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @once
        @push('scripts')
            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        @endpush

        @push('styles')
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
                  rel="stylesheet">
        @endpush
    @endonce
</div>
