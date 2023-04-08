<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updatePlaylist">
        <x-slot name="title">
            {{ __('Edit Playlist') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="playlist.name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="playlist.name" class="mt-2"/>
            </div>
            <div class="col-span-6">
                <x-input.label value="Number of Items Per Page" required />
                <x-input.text id="per_page" wire:model.defer="playlist.per_page" placeholder="5" min="1" max="100" required />
                <x-jet-input-error for="playlist.per_page" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-danger-button wire:click="$toggle('deletePlaylistModalOpen')" class="mr-2">Delete</x-jet-danger-button>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-form.section>

    <x-jet-confirmation-modal wire:model="deletePlaylistModalOpen">
        <x-slot name="title">Delete Playlist: {{ $playlist->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this playlist?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deletePlaylistModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deletePlaylist" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
