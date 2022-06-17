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
    public $clickable;

    public function mount(Post $post, $clickable = true) {
        $this->post = $post;
        $this->clickable = $clickable;
    }

    public function getAuthorProperty() {
        return $this->post->user;
    }

    public function showPost() {
        if ($this->clickable) {
            return $this->redirectRoute('social.posts.show', $this->post);
        }
    }

    public function showProfile() {
        return $this->redirectRoute('social.profile.show', $this->author->handle);
    }

    public function toggleBookmark()
    {
        if ($this->post->isBookmarkedBy()) {
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
