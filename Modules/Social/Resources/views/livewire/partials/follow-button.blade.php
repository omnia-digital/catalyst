<div class="inline-flex items-center text-md">
    <button type="button" class="inline-flex items-center px-3 py-0.5 rounded-full bg-rose-50 text-sm font-medium text-rose-700 hover:bg-rose-100" wire:click="follow">
        @if ($model->isFollowedBy($this->authUser))
            <x-heroicon-o-minus-sm class="-ml-1 mr-0.5 h-5 w-5 text-rose-700" aria-hidden="true" />
            <span>Unfollow</span>
        @else
            <x-heroicon-o-plus-sm class="-ml-1 mr-0.5 h-5 w-5 text-rose-700" aria-hidden="true" />
            <span>Follow</span>
        @endif
    </button>
</div>
