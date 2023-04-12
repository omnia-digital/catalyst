<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

use function view;

class PostCard extends Component
{
    use WithNotification, WithGuestAccess;

    public Post $post;
    public $optionsMenuOpen = false;
    public $clickable;
    public $showPostActions = true;

    public function loadRelations()
    {
        $this->post->load(['user', 'team', 'media', 'repostOriginal', 'tags']);
    }

    public function mount(Post $post, $clickable = true, $showPostActions = true)
    {
        $this->post = $post;
        $this->clickable = $clickable;
        $this->showPostActions = $showPostActions;
        $this->loadRelations();
    }

    public function getAuthorProperty()
    {
        return $this->post->user;
    }

    public function showPost()
    {
        if ($this->clickable) {
            return $this->redirectRoute('social.posts.show', $this->post);
        }
    }

    public function showProfile($handle = null, $team = false)
    {
        if ($team) {
            return $this->redirectRoute('social.teams.show', $handle);
        }
        if ($handle) {
            return $this->redirectRoute('social.profile.show', $handle);
        }

        return $this->redirectRoute('social.profile.show', $this->author->handle);
    }

    public function toggleBookmark()
    {
        if (Platform::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal(route('social.posts.show', $this->post));

            return;
        }

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

    /**
     * Confirm delete post.
     *
     * @return void
     */
    public function confirmDeletePost()
    {
        $this->emitTo('social::delete-post-modal', 'openDeletePostModal', $this->post->id);
    }

    public function render()
    {
        return view('social::livewire.components.post-card');
    }
}
