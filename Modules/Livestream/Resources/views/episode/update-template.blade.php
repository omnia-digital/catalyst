<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateEpisodeTemplate">
        <x-slot name="title">
            {{ __('Edit Episode Template') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="name" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Title" required/>
                <x-input.text id="episode-title" wire:model="title" placeholder="{{ __('Episode Title') }}"/>
                <x-input-error for="title" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Description" required/>
                <x-input.textarea id="episode-description" wire:model="description"
                                  placeholder="{{ __('Episode Description') }}"/>
                <x-input-error for="description" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Thumbnail"/>
                <x-input.filepond id="episode-thumbnail" wire:model="thumbnail"
                                  :defaultImage="$currentThumbnail"/>
                <x-input-error for="thumbnail" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Series"/>
                <x-input.selects wire:model="selectedSeries" id="series" :options="$series"/>
                <x-input-error for="selectedSeries" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Topics"/>
                <x-input.text id="topics" wire:model="topics" placeholder="Topics"/>
                <x-input-error for="topics" class="mt-2"/>
                <x-input.help>Each topic will be seperated by a comma (,).</x-input.help>
            </div>

            <div class="col-span-6">
                <x-episode-template-shortcodes/>
            </div>
        </x-slot>

        <x-slot name="actions">
            @can('delete', $episodeTemplate)
                <x-danger-button wire:click="$toggle('deleteEpisodeTemplateModalOpen')" class="mr-2">Delete
                </x-danger-button>
            @endif

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form.section>

    <x-confirmation-modal wire:model.live="deleteEpisodeTemplateModalOpen">
        <x-slot name="title">Delete Episode Template: {{ $episodeTemplate->title }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this episode template?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deleteEpisodeTemplateModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteEpisodeTemplate" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
