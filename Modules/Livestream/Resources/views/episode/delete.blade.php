<div>
    <x-form.button wire:click.prevent="$set('deleteEpisodeModalOpen', true)" secondary danger>Delete</x-form.button>

    <x-confirmation-modal wire:model.live="deleteEpisodeModalOpen">
        <x-slot name="title">
            {{ __('Delete Episode') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this episode? Once a episode is deleted, it cannot be reverted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('deleteEpisodeModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteEpisode" wire:loading.attr="disabled">
                {{ __('Delete Episode') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
