<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateEpisodeTemplate">
        <x-slot name="title">
            {{ __('Edit Episode Template') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="name" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Title" required/>
                <x-input.text id="episode-title" wire:model.defer="title" placeholder="{{ __('Episode Title') }}"/>
                <x-jet-input-error for="title" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Description" required/>
                <x-input.textarea id="episode-description" wire:model.defer="description" placeholder="{{ __('Episode Description') }}"/>
                <x-jet-input-error for="description" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Episode Thumbnail"/>
                <x-input.filepond id="episode-thumbnail" wire:model.defer="thumbnail" :defaultImage="$currentThumbnail"/>
                <x-jet-input-error for="thumbnail" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Series"/>
                <x-input.selects wire:model.defer="selectedSeries" id="series" :options="$series"/>
                <x-jet-input-error for="selectedSeries" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Topics"/>
                <x-input.text id="topics" wire:model.defer="topics" placeholder="Topics"/>
                <x-jet-input-error for="topics" class="mt-2"/>
                <x-input.help>Each topic will be seperated by a comma (,).</x-input.help>
            </div>

            <div class="col-span-6">
                <x-episode-template-shortcodes/>
            </div>
        </x-slot>

        <x-slot name="actions">
            @can('delete', $episodeTemplate)
                <x-jet-danger-button wire:click="$toggle('deleteEpisodeTemplateModalOpen')" class="mr-2">Delete</x-jet-danger-button>
            @endif

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-form.section>

    <x-jet-confirmation-modal wire:model="deleteEpisodeTemplateModalOpen">
        <x-slot name="title">Delete Episode Template: {{ $episodeTemplate->title }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this episode template?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteEpisodeTemplateModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteEpisodeTemplate" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
