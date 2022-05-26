<div class="space-y-2">
    @foreach ($feed as $post)
        <livewire:social::components.post-card-dynamic :post="$post"/>
    @endforeach
</div>
