<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateChannel">
        <x-slot name="title">
            {{ __('Edit Channel') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="channel.name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="channel.name" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Player" required/>
                <x-input.select id="player" wire:model.defer="channel.player_id" :options="$players"/>
                <x-jet-input-error for="channel.player_id" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-danger-button wire:click="$toggle('deleteChannelModalOpen')" class="mr-2">Delete</x-jet-danger-button>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-form.section>

    <x-jet-confirmation-modal wire:model="deleteChannelModalOpen">
        <x-slot name="title">Delete Channel: {{ $channel->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this channel?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteChannelModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteChannel" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
