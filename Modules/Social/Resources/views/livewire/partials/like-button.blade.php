<div x-data x-on:click.stop="">
    <div class="inline-flex items-center text-md">
        <button class="inline-flex space-x-2 text-light-text-color hover:text-base-text-color"
                wire:click.prevent.stop="like">
            @if ($model->isLiked)
                <x-library::icons.icon name="fas-thumb-up" :class="'h-6 w-6 ' . $btnStyles" aria-hidden="true"/>
            @else
                <x-library::icons.icon name="fas-thumb-up" :class="'h-6 w-6 ' . $btnStyles" aria-hidden="true"/>
            @endif
            @unless ($hideCount)
                <span class="font-medium text-dark-text-color">{{ $model->likesCount() > 0 ? $model->likesCount() : '' }}</span>
            @endunless
            <span class="sr-only">likes</span>
        </button>
    </div>
    @if ($withDislikes)
        <div class="inline-flex items-center text-md">
            <button class="inline-flex space-x-2 text-light-text-color hover:text-base-text-color"
                    wire:click.prevent.stop="dislike">
                @if ($model->isDisliked)
                    <x-library::icons.icon name="fas-thumb-down" :class="'h-6 w-6 ' . $btnStyles" aria-hidden="true"/>
                @else
                    <x-library::icons.icon name="fas-thumb-down" :class="'h-6 w-6 ' . $btnStyles" aria-hidden="true"/>
                @endif
                @unless ($hideCount)
                    <span class="font-medium text-dark-text-color">{{ $model->dislikesCount() > 0 ? $model->dislikesCount() : '' }}</span>
                @endunless
                <span class="sr-only">dislikes</span>
            </button>
        </div>
    @endif
</div>
