<x-library::dropdown.item wire:click.prevent.stop="confirmDeletePost" wire:loading.attr="disabled">
    <div class="inline-flex items-center text-sm">
        <div class="text-danger-600 flex items-center space-x-1">
            <x-heroicon-o-trash :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true"/>
            <p class="text-danger-600"> Delete</p>
        </div>
    </div>
</x-library::dropdown.item>
