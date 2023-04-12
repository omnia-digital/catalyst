<div>
    <x-form.button wire:click.prevent="$set('deletePersonModalOpen', true)" secondary danger>Delete</x-form.button>

    <x-jet-confirmation-modal wire:model="deletePersonModalOpen">
        <x-slot name="title">
            {{ __('Delete Person') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this person? Once a person is deleted, it cannot be reverted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('deletePersonModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deletePerson" wire:loading.attr="disabled">
                {{ __('Delete Person') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
