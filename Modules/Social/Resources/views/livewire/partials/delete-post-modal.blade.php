<x-confirmation-modal wire:model.live="confirmingDeletePost">
    <x-slot name="title">
        {{ Trans::get('Delete Post') }}
    </x-slot>

    <x-slot name="content">
        {{ Trans::get('Are you sure you want to delete this post? It cannot be undone.') }}
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click.prevent.stop="$toggle('confirmingDeletePost')" wire:loading.attr="disabled">
            {{ Trans::get('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ml-2" wire:click.prevent.stop="deletePost" wire:loading.attr="disabled">
            {{ Trans::get('Confirm') }}
        </x-danger-button>
    </x-slot>
</x-confirmation-modal>
