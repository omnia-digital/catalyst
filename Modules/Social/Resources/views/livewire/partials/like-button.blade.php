<div class="inline-flex items-center text-md">
    <button class="inline-flex space-x-2 text-color-light hover:text-color-base" wire:click="like">
        @if ($model->isLiked)
            <x-heroicon-s-thumb-up :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true" />
        @else
            <x-heroicon-o-thumb-up :class="$show ? 'h-6 w-6' : 'h-5 w-5'" aria-hidden="true" />
        @endif
        <span class="font-medium text-color-dark">{{ $model->likesCount() > 0 ? $model->likesCount() : '' }}</span>
        <span class="sr-only">likes</span>
    </button>
</div>
