<div class="bg-gray-50 min-h-screen">
    <form wire:submit.prevent="submit" wire:loading.class="cursor-wait" wire:target="submit" class="p-8 space-y-8 max-w-4xl mx-auto">
        @unless ($formSubmitted)
            <div class="p-8 bg-white shadow">
                {{ $this->form }}
            </div>

            <x-forms::button type="submit" wire:loading.attr="disabled" wire:target="submit">
                <span class="text-base-text-color" wire:loading.remove wire:target="submit">Submit</span>
                <span class="text-base-text-color" wire:loading wire:target="submit">Processing...</span>
            </x-forms::button>
        @else
        <div class="p-8 bg-white shadow">
            <p>Your form was submitted successfully.</p>
        </div>
        @endunless
    </form>
</div>
