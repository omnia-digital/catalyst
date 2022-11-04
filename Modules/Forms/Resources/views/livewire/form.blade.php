<div>
    <form wire:submit.prevent="submit" wire:loading.class="cursor-wait" wire:target="submit" class="p-8 space-y-8 max-w-4xl mx-auto">
        @unless ($formSubmitted)
            <div>
                {{ $this->form }}
            </div>

            <x-forms::button type="submit" class="hover:bg-neutral-hover w-full focus:ring-1" wire:loading.attr="disabled" wire:target="submit">
                <span class="text-base-text-color" wire:loading.remove wire:target="submit">{{ $submitText }}</span>
                <span class="text-base-text-color" wire:loading wire:target="submit">Processing...</span>
            </x-forms::button>
        @else
            <div class="p-8 bg-white shadow">
                <p>{{ \Trans::get('Your form was submitted successfully.') }}</p>
            </div>
        @endunless
    </form>
</div>
