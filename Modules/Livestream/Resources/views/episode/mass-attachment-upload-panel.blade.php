<div>
    @if ($viewReport)
        <p>The Following Report sent by Email</p>
        <div class="mt-4 w-full overflow-x-scroll">
            {!! $reportHtml !!}
        </div>
        <x-button wire:click="closeReport" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-button>
    @else
        <div class="mt-4">
            <x-input.label value="Attachment" required/>
            <x-input.filepond id="massAttachments" wire:model="massAttachments" multiple/>
            <x-input-error for="massAttachments.*" class="mt-2"/>
        </div>
        <div class="flex justify-between items-center">
            <x-button wire:click="openReport" wire:loading.attr="disabled">
                {{ __('Send Report') }}
            </x-button>
            <x-button class="ml-2" wire:click="process" wire:loading.attr="disabled">
                {{ __('Process') }}
            </x-button>
        </div>
    @endif
</div>
