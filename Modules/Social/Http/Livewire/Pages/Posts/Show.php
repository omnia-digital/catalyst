<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    protected $listeners = ['postAdded' => '$refresh'];

    public $post;
    public $recentlyAddedComment;

    public function postAdded(Post $post)
    {
        $this->recentlyAddedComment = $post;
    }

    public function mount($post)
    {
        $this->post = Post::withoutGlobalScope('parent')->findOrFail($post);

        if ($this->post->type === PostType::RESOURCE) {
            $this->redirectRoute('resources.show', $this->post->id);

            return;
        }

        $this->post = $this->post->load('comments');
    }

    public function render()
    {
        return view('social::livewire.pages.posts.show');
    }
}
