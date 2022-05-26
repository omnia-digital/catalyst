@if($post->type == \Modules\Social\Enums\PostType::RESOURCE)
    <livewire:resources::components.resource-card
            :post="$post"
            :wire:key="'resource-card-' . $post->id"
            :show-post-actions="true"
    />
@else
    <livewire:social::components.post-card wire:key="post-{{ $post->id }}"
                                           :post="$post"
                                           :show-post-actions="false"

    />
@endif
