<button wire:loading.attr="disabled"
        wire:loading.class.remove="bg-secondary hover:bg-secondary-dark focus:ring-secondary"
        wire:loading.class="bg-gray-500 cursor-not-allowed"
        {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white
        bg-secondary hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-light focus:ring-secondary']) }}
>
    <div>
        <span wire:loading {{ $attributes->only('wire:target') }}>Loading...</span>
        <span wire:loading.remove {{ $attributes->only('wire:target') }}>{{ $slot ?? 'Submit' }}</span>
    </div>
</button>
