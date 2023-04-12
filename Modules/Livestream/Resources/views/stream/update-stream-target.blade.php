<div class="w-1/4 mx-auto py-10 sm:px-6 lg:px-8">
    <x-form.section submit="updateStreamTarget">
        <x-slot name="title">
            {{ __('Edit Stream Target') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="streamTarget.name" placeholder="{{ __('Facebook') }}"/>
                <x-jet-input-error for="streamTarget.name" class="mt-2"/>
            </div>

{{--            <div class="col-span-6">--}}
{{--                <x-input.label value="URL" required/>--}}
{{--                <x-input.text id="url" wire:model.defer="streamTarget.url" placeholder="{{ __('URL') }}"/>--}}
{{--                <x-jet-input-error for="streamTarget.url" class="mt-2"/>--}}
{{--            </div>--}}

{{--            <div class="col-span-6">--}}
{{--                <x-input.label value="Stream Key" required/>--}}
{{--                <x-input.text id="stream-key" wire:model.defer="streamTarget.stream_key" placeholder="{{ __('Stream Key') }}"/>--}}
{{--                <x-jet-input-error for="streamTarget.stream_ke" class="mt-2"/>--}}
{{--            </div>--}}
        </x-slot>

        <x-slot name="actions">
            <x-jet-danger-button wire:click="$toggle('deleteStreamTargetModalOpen')" class="mr-2">Delete</x-jet-danger-button>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-form.section>

    <x-jet-confirmation-modal wire:model="deleteStreamTargetModalOpen">
        <x-slot name="title">Delete Stream Target: {{ $streamTarget->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this stream target?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteStreamTargetModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteStreamTarget" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
