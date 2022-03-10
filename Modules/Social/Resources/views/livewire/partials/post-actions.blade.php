<div class="py-4 flex justify-between space-x-24 pr-24">
    <livewire:social::replies-modal :post="$post" :wire:key="'post-' . $post->id . '-replies'" :show="$show"/>
    <livewire:social::partials.repost-button :model="$post" :show="$show"/>
    <livewire:social::partials.like-button :model="$post" :show="$show"/>
    <livewire:social::partials.share-button :model="$post" :show="$show"/>
</div>
