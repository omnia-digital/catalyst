@php use App\Enums\VideoStorageOption; @endphp
<x-form.section submit="saveVideoStorageOption">
    <x-slot name="form">
        <div class="col-span-6">
            <x-input.label value="Video Storage"/>
            <x-input.select id="video-storage" wire:model.live="videoStorage" :options="$videoStorageOptions"/>
            <x-input-error for="videoStorage" class="mt-2"/>
        </div>

        @if ($videoStorage === VideoStorageOption::DELETE_VIDEO && $expiredEpisodeCount > 0)
            <div class="col-span-6">
                <x-alert.danger>You have {{ $expiredEpisodeCount }}
                    expired {{ Str::plural('episodes', $expiredEpisodeCount) }}. They will be deleted when you press
                    Save button.
                </x-alert.danger>
            </div>
        @endif

        <x-confirmation-modal wire:model.live="confirmingVideoDeletion">
            <x-slot name="title">
                {{ __('Turn On Auto-Delete') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to turn on Auto-Delete?') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingVideoDeletion')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="saveVideoStorageOption" wire:loading.attr="disabled">
                    {{ __('Yes, Turn On Auto-Delete') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form.section>
