<div class="space-y-2">
    @foreach ($feed as $post)
        <livewire:social::components.post-card-dynamic :post="$post"/>
    @endforeach

    @if($hasMorePages)
        <button wire:click.prevent="loadPosts">Load More</button>
    @endif
</div>

@if($hasMorePages)
        <div x-data="{
                observe () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                window.livewire.emit('load-more');

                                @this.call('loadPosts')
                            }
                        })
                    }, {
                        root: null
                    });
                    observer.POLL_INTERVAL = 100
                    observer.observe(this.$el);
                }
            }"
                class="grid grid-cols-1 gap-8 mt-4 md:grid-cols-1 lg:grid-cols-1"
                x-init="observe"
        >
        </div>
@endif
