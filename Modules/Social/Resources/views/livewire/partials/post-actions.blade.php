<div class="py-4 flex text-light-text-color  justify-between space-x-24 pr-24">
    @if ($post->isParent())
        <livewire:social::replies-modal :post="$post" wire:key="replies-post-{{ $post->id }}" :show="$show"/>
    @endif

    <livewire:social::partials.like-button :model="$post" :show="$show"/>
    <livewire:social::partials.repost-button :model="$post" :show="$show"/>
    <livewire:social::partials.share-button :model="$post" :show="$show"/>
</div>
