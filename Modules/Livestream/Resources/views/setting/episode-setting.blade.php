<x-action-section>
    <x-slot name="content">
        <div class="text-sm text-gray-600">
            @if ($this->team->livestreamAccount->hasEpisodes())
                {{ __('Once episodes are deleted, they cannot be reverted. Before deleting episodes, please download all episodes that you wish to retain.') }}
            @else
                <p class="text-sm font-semibold">You don't have any episodes.</p>
            @endif
        </div>

        @if ($this->team->livestreamAccount->hasEpisodes())
            <div class="mt-5">
                <x-danger-button wire:click="$toggle('confirmingEpisodesDeletion')" wire:loading.attr="disabled">
                    {{ __('Delete All Episodes') }}
                </x-danger-button>
            </div>
        @endif

        <x-confirmation-modal wire:model.live="confirmingEpisodesDeletion">
            <x-slot name="title">
                {{ __('Delete All Episodes') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete all episodes? Once episodes are deleted, they cannot be reverted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingEpisodesDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="deleteAllEpisodes" wire:loading.attr="disabled">
                    {{ __('Delete All Episodes') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>
