<div>
    <x-form.button wire:click="$set('moveEpisodeModalOpen', true)" secondary danger>Move</x-form.button>

    <x-dialog-modal wire:model.live="moveEpisodeModalOpen">
        <x-slot name="title">Move Episode</x-slot>
        <x-slot name="content">
            <div>
                @empty($organizations)
                    <p>It doesn't look like you have access to any other organizations</p>
                @else
                    <x-input.label value="Your other organizations" required/>
                    <x-input.select id="organization" wire:model="organization" :options="$organizations"
                                    placeholder="Please select an organization"/>
                @endif
                <x-input-error for="organization" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('moveEpisodeModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            @empty(!$organizations)
                <x-button class="ml-2" wire:click="moveEpisode" wire:loading.attr="disabled">
                    {{ __('Move Episode') }}
                </x-button>
            @endif
        </x-slot>
    </x-dialog-modal>
</div>
