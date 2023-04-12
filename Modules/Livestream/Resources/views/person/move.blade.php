<div>
    <x-form.button wire:click="$set('movePersonModalOpen', true)" secondary danger>Move</x-form.button>

    <x-jet-dialog-modal wire:model="movePersonModalOpen">
        <x-slot name="title">Move Person</x-slot>
        <x-slot name="content">
            <div>
                @empty($organizations)
                    <p>It doesn't look like you have access to any other organizations</p>
                @else
                    <x-input.label value="Your other organizations" required/>
                    <x-input.select id="organization" wire:model.defer="organization" :options="$organizations" placeholder="Please select an organization"/>
                @endif
                <x-jet-input-error for="organization" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('movePersonModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @empty(!$organizations)
                <x-jet-button class="ml-2" wire:click="movePerson" wire:loading.attr="disabled">
                    {{ __('Move Person') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
