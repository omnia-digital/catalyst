<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    public $resource;

    public function mount($resource): void
    {
        $this->resource = Post::withoutGlobalScope('parent')->find($resource);

        if (!empty($this->resource) && $this->resource->type !== PostType::RESOURCE) {
            $this->redirectRoute('social.posts.show', $this->resource);
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('resources::livewire.pages.resources.show');
    }
}
