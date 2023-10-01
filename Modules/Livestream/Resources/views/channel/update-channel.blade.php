<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateChannel">
        <x-slot name="title">
            {{ __('Edit Channel') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="channel.name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="channel.name" class="mt-2"/>
            </div>

            <div class="col-span-6">
                <x-input.label value="Player" required/>
                <x-input.select id="player" wire:model="channel.player_id" :options="$players"/>
                <x-input-error for="channel.player_id" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-danger-button wire:click="$toggle('deleteChannelModalOpen')" class="mr-2">Delete</x-danger-button>

            <x-button>
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form.section>

    <x-confirmation-modal wire:model.live="deleteChannelModalOpen">
        <x-slot name="title">Delete Channel: {{ $channel->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this channel?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deleteChannelModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteChannel" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
