<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    use AuthorizesRequests;

    public $resource;

    public function mount($resource)
    {
        $this->resource = Post::withoutGlobalScope('parent')->find($resource);

        if (is_null($this->resource->published_at)) {
            // If it's a draft only the owner can view it
            $this->authorize('update', $this->resource);
        }

        if (! empty($this->resource) && $this->resource->type !== PostType::ARTICLE) {
            $this->redirectroute('catalyst-social.posts.show', $this->resource);
        }
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.show');
    }
}
