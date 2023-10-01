@php use Modules\Social\Enums\PostType; @endphp
@if ($post->type == PostType::ARTICLE)
    <livewire:articles::components.article-card
            :post="$post"
            :wire:key="'article-card-' . $post->id"
            :show-post-actions="true"
    />
@elseif ($post->type == PostType::RESOURCE && Route::is('resources.home'))
    <livewire:resources::components.resource-media-card
            :post="$post"
            :wire:key="'resource-card-' . $post->id"
            :show-post-actions="false"
            :show-details="false"
    />
@else
    <livewire:social::components.post-card wire:key="post-{{ $post->id }}"
                                           :post="$post"
                                           :show-post-actions="true"
                                           :clickable="$clickable"

    />
@endif
