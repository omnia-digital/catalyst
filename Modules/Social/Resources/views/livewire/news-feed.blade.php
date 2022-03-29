<div class="space-y-4">
    @foreach ($feeds as $feed)
        <x-social::post.card wire:key="post-{{ $feed->id }}" :post="$feed"/>
    @endforeach
</div>
