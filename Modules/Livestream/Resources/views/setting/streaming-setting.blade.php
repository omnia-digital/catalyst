<x-form.section submit="updateStreamingSetting">
    <x-slot name="form">
        <div class="col-span-6">
            <x-input.label value="CDN Playback URL"/>
            <x-input.text id="cdn-playback-url" wire:model="streaming.cdn_playback_url"/>
            <x-input-error for="streaming.cdn_playback_url" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-input.label value="Mux Livestream Active"/>
            <x-input.toggle id="mux-livestream-active" wire:model="streaming.mux_livestream_active"/>
            <x-input-error for="streaming.mux_livestream_active" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-input.label value="Mux VOD Active"/>
            <x-input.toggle id="mux-vod-active" wire:model="streaming.mux_vod_active"/>
            <x-input-error for="streaming.mux_vod_active" class="mt-2"/>
        </div>

        <div class="col-span-6">
            <x-input.label value="Mux Stream Targets Active"/>
            <x-input.toggle id="mux-stream-targets-active" wire:model="streaming.mux_stream_targets_active"/>
            <x-input-error for="streaming.mux_stream_targets_active" class="mt-2"/>
        </div>
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
