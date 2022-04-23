<div class="inline-flex items-center text-md">
    <button wire:click="toggleBookmark" type="button" class="inline-flex space-x-2 text-light-text-color hover:text-base-text-color">
        @if ($model->isBookmarkedBy())
            <x-heroicon-s-bookmark class="h-5 w-5"/>
        @else
            <x-heroicon-o-bookmark class="h-5 w-5"/>
        @endif

        <span class="font-medium text-dark-text-color">{{ $model->bookmarks_count > 0 ? $model->bookmarks_count : '' }}</span>
        <span class="sr-only">bookmarks</span>
    </button>
</div>
