<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Support\Platform\Platform;
use App\Support\Platform\WithLoginModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasBookmarkedNotification;

class BookmarkButton extends Component
{
    use WithLoginModal;

    public Post $model;

    public bool $show = false;

    public function toggleBookmark()
    {
        if (Platform::isAllowingGuestAccess() && !Auth::check()) {
            $this->showLoginModal(route('social.posts.show', $this->model));

            return;
        }

        if ($this->model->isBookmarkedBy()) {
            $this->model->removeBookmark();
        } else {
            $this->model->markAsBookmark();

            $this->model->user->notify(new PostWasBookmarkedNotification($this->model, Auth::user()));
        }

        $this->model->refresh();
        $this->model->loadCount('bookmarks');
    }

    public function render()
    {
        return view('social::livewire.partials.bookmark-button');
    }
}
