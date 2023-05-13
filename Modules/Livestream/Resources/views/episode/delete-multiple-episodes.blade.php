<div>
    <x-form.button wire:click.prevent="$set('deleteMultipleEpisodesModalOpen', true)" secondary danger>Delete Selected</x-form.button>

    <x-jet-confirmation-modal wire:model="deleteMultipleEpisodesModalOpen">
        <x-slot name="title">
            {{ __('Delete Episodes') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the selected episodes? Once they are deleted, they cannot be restored.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('deleteMultipleEpisodesModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteEpisodes" wire:loading.attr="disabled">
                {{ __('Delete Episodes') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
