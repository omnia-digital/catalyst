<div wire:model.live="$show" class="w-full py-4 flex text-light-text-color justify-between">
    @if ($showCommentButton && $post->isParent())
        <livewire:social::replies-modal :post="$post" wire:key="replies-post-{{ $post->id }}" :show="$show"/>
    @endif

    @if ($showLikeButton)
        <livewire:social::partials.like-button :model="$post"/>
    @endif
    @if ($showRepostButton)
        <livewire:social::partials.repost-button :model="$post" :show="$show"/>
    @endif
    @if ($showShareButton)
        <livewire:social::partials.share-button :model="$post" :show="$show"/>
    @endif

    @if ($showBookmarkButton)
        <livewire:social::partials.bookmark-button :model="$post"/>
    @endif
</div>
