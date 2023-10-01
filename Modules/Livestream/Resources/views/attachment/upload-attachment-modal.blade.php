<x-dialog-modal wire:model.live="uploadAttachmentModalOpen">
    <x-slot name="title">Add Attachment</x-slot>
    <x-slot name="content">
        <div class="flex items-center space-x-4">
            <x-input.label value="From URL"/>
            <x-input.toggle wire:model.live="isUpload"/>
            <x-input.label value="Upload"/>
        </div>
        <div class="mt-4">
            @if ($isUpload)
                <x-input.label value="Attachment" required/>
                <x-input.filepond id="attachment" wire:model="attachment"/>
                <x-input-error for="attachment" class="mt-2"/>
            @else
                <x-input.label value="URL"/>
                <x-input.text id="url" wire:model="url" placeholder="URL"/>
                <x-input-error for="url" class="mt-2"/>
            @endif
        </div>
        <div class="mt-4">
            <x-input.label value="Name"/>
            <x-input.text id="name" wire:model="name" placeholder="Name"/>
            <x-input-error for="name" class="mt-2"/>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('uploadAttachmentModalOpen')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
