<div class="space-y-2">
    @foreach ($feed as $post)
        <livewire:social::components.post-card-dynamic :post="$post" wire:key="feed-item-{{ $post->id }}" />
    @endforeach
</div>
