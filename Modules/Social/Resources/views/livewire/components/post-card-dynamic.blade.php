@if ($post->type == \Modules\Social\Enums\PostType::ARTICLE)
    <livewire:articles::components.article-card
            :post="$post"
            :wire:key="'article-card-' . $post->id"
            :show-post-actions="true"
    />
@elseif ($post->type == \Modules\Social\Enums\PostType::RESOURCE)
    <livewire:resources::components.resource-media-card
            :post="$post"
            :wire:key="'resource-card-' . $post->id"
            :show-details="true"
    />
@else
    <livewire:social::components.post-card wire:key="post-{{ $post->id }}"
                                           :post="$post"
                                           :show-post-actions="true"
                                           :clickable="$clickable"

    />
@endif
