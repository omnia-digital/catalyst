<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Models\Post;

class Show extends Component
{
    public Post $resource;

    public function mount(Post $resource)
    {
        if ($resource->type->value !== 'resource') {
            $this->redirectRoute('social.posts.show', $resource);
        }
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.show');
    }
}
