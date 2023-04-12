<div>
    @if ($viewReport)
        <p>The Following Report sent by Email</p>
        <div class="mt-4 w-full overflow-x-scroll">
            {!! $reportHtml !!}
        </div>
        <x-jet-button wire:click="closeReport" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-jet-button>
    @else
        <div class="mt-4">
                <x-input.label value="Attachment" required />
                <x-input.filepond id="massAttachments" wire:model.defer="massAttachments" multiple />
                <x-jet-input-error for="massAttachments.*" class="mt-2" />
        </div>
        <div class="flex justify-between items-center">
            <x-jet-button wire:click="openReport" wire:loading.attr="disabled">
                {{ __('Send Report') }}
            </x-jet-button>
            <x-jet-button class="ml-2" wire:click="process" wire:loading.attr="disabled">
                {{ __('Process') }}
            </x-jet-button>
        </div>
    @endif
</div>