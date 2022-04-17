<div class="space-y-4">
    @foreach ($feeds as $feed)
        <livewire:social::components.post-card wire:key="post-{{ $feed->id }}" :post="$feed"/>
    @endforeach
</div>
