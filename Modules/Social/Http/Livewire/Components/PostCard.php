<?php

namespace Modules\Social\Http\Livewire\Components;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class PostCard extends Component
{
    use WithNotification;

    public Post $post;
    public $optionsMenuOpen = false;

    public function mount(Post $post) {
        $this->post = $post;
    }

    public function getAuthorAttribute() {
        return $this->post->user;
    }

    public function toggleBookmark()
    {
        if ($this->post->isBookmarked()) {
            $this->post->removeBookmark();
            $this->post->refresh();

            $this->success('Remove bookmark successfully!');

            return;
        }

        $this->post->markAsBookmark();
        $this->post->refresh();

        $this->success('Bookmark the resource successfully!');
    }

    public function render()
    {
        return view('social::livewire.components.post-card');
    }
}
