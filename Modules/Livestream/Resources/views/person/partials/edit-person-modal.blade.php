<div>
    @if ($state)
        <x-dialog-modal wire:model.live="editModalOpen">
            <x-slot name="title">Edit Person</x-slot>
            <x-slot name="content">
                <div>
                    <x-input.label value="First Name" required/>
                    <x-input.text id="first-name" wire:model="state.first_name" placeholder="First Name"/>
                    <x-input-error for="state.first_name" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Last Name" required/>
                    <x-input.text id="last-name" wire:model="state.last_name" placeholder="Last Name"/>
                    <x-input-error for="state.last_name" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Email" required/>
                    <x-input.text type="email" id="email" wire:model="state.email" placeholder="Email"/>
                    <x-input-error for="state.email" class="mt-2"/>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="hideEditModal" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-button class="ml-2" wire:click="updatePerson" wire:loading.attr="disabled">
                    {{ __('Update Person') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
