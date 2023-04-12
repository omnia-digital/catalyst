<x-jet-dialog-modal wire:model="uploadAttachmentModalOpen">
    <x-slot name="title">Add Attachment</x-slot>
    <x-slot name="content">
        <div class="flex items-center space-x-4">
            <x-input.label value="From URL"/>
            <x-input.toggle wire:model="isUpload"/>
            <x-input.label value="Upload"/>
        </div>
        <div class="mt-4">
            @if ($isUpload)
                <x-input.label value="Attachment" required/>
                <x-input.filepond id="attachment" wire:model.defer="attachment"/>
                <x-jet-input-error for="attachment" class="mt-2"/>
            @else
                <x-input.label value="URL"/>
                <x-input.text id="url" wire:model.defer="url" placeholder="URL"/>
                <x-jet-input-error for="url" class="mt-2"/>
            @endif
        </div>
        <div class="mt-4">
            <x-input.label value="Name"/>
            <x-input.text id="name" wire:model.defer="name" placeholder="Name"/>
            <x-jet-input-error for="name" class="mt-2"/>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('uploadAttachmentModalOpen')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
