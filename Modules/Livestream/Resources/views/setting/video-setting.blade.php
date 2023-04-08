<x-form.section submit="saveVideoStorageOption">
    <x-slot name="form">
        <div class="col-span-6">
            <x-input.label value="Video Storage"/>
            <x-input.select id="video-storage" wire:model="videoStorage" :options="$videoStorageOptions"/>
            <x-jet-input-error for="videoStorage" class="mt-2"/>
        </div>

        @if ($videoStorage === \App\Enums\VideoStorageOption::DELETE_VIDEO && $expiredEpisodeCount > 0)
            <div class="col-span-6">
                <x-alert.danger>You have {{ $expiredEpisodeCount }} expired {{ Str::plural('episodes', $expiredEpisodeCount) }}. They will be deleted when you press Save button.</x-alert.danger>
            </div>
        @endif

        <x-jet-confirmation-modal wire:model="confirmingVideoDeletion">
            <x-slot name="title">
                {{ __('Turn On Auto-Delete') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to turn on Auto-Delete?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingVideoDeletion')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="saveVideoStorageOption" wire:loading.attr="disabled">
                    {{ __('Yes, Turn On Auto-Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-form.section>
