<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updatePlaylist">
        <x-slot name="title">
            {{ __('Edit Playlist') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="playlist.name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="playlist.name" class="mt-2"/>
            </div>
            <div class="col-span-6">
                <x-input.label value="Number of Items Per Page" required/>
                <x-input.text id="per_page" wire:model="playlist.per_page" placeholder="5" min="1" max="100"
                              required/>
                <x-input-error for="playlist.per_page" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-danger-button wire:click="$toggle('deletePlaylistModalOpen')" class="mr-2">Delete</x-danger-button>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form.section>

    <x-confirmation-modal wire:model.live="deletePlaylistModalOpen">
        <x-slot name="title">Delete Playlist: {{ $playlist->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this playlist?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deletePlaylistModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deletePlaylist" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
