<div>
    @auth()
        @if (auth()->user()->id != $model->id )
            <div class="inline-flex items-center text-md">
                @if ($model->isFollowedBy($this->authUser))
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 rounded-full bg-secondary text-base-text-color text-sm tracking-wide font-medium border border-primary hover:bg-neutral-light"
                            wire:click="follow">
                        <span>Following</span>
                    </button>
                @else
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-white-text-color text-sm tracking-wide font-medium hover:opacity-75"
                            wire:click="follow">
                        <span>Follow</span>
                    </button>
                @endif
            </div>
        @endif
    @endauth
</div>
