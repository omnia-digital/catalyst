<div class="lg:w-1/2 w-full mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateSeries">
        <x-slot name="title">
            {{ __('Edit Series') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="series.name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="series.name" class="mt-2"/>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-danger-button wire:click="$toggle('deleteSeriesModalOpen')" class="mr-2">Delete</x-jet-danger-button>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-form.section>

    <x-jet-confirmation-modal wire:model="deleteSeriesModalOpen">
        <x-slot name="title">Delete Series: {{ $series->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this series?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteSeriesModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteSeries" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>