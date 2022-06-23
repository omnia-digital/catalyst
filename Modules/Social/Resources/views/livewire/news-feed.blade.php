<div class="space-y-2">
    @foreach ($feed as $post)
        <livewire:social::components.post-card-dynamic :post="$post" wire:key="feed-item-{{ $post->id }}"/>
    @endforeach
    <div>
        @if ($this->hasMore())
            <div>
                <x-library::button wire:click="loadMore" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-primary border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    Load More
                </x-library::button>
            </div>
        @endif
    </div>
</div>
