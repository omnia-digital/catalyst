<div class="px-24 mt-6 flex justify-between">
    <livewire:social::replies-modal :post="$post" :wire:key="'post-' . $post->id . '-replies'" :show="$show"/>
    <livewire:social::partials.repost-button :model="$post" :show="$show"/>
    <livewire:social::partials.like-button :model="$post" :show="$show"/>
    <livewire:social::partials.share-button :model="$post" :show="$show"/>
</div>
