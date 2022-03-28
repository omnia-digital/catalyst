<div class="inline-flex items-center text-md">
    @if ($model->isFollowedBy($this->authUser))
        <button type="button" class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-black text-sm tracking-wide font-medium border border-black hover:bg-gray-200" wire:click="follow">
            <span>Following</span>
        </button>
    @else
        <button type="button" class="inline-flex items-center px-4 py-2 rounded-full bg-black text-white text-sm tracking-wide font-medium hover:opacity-75" wire:click="follow">
            <span>Follow</span>
        </button>
    @endif
</div>
