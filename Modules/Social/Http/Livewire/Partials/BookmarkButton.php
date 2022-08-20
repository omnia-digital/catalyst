<?php

namespace Modules\Social\Http\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasBookmarkedNotification;

class BookmarkButton extends Component
{
    public Post $model;

    public bool $show = false;

    public function toggleBookmark(): void
    {
        if ($this->model->isBookmarkedBy()) {
            $this->model->removeBookmark();
        } else {
            $this->model->markAsBookmark();

            $this->model->user->notify(new PostWasBookmarkedNotification($this->model, Auth::user()));
        }

        $this->model->refresh();
        $this->model->loadCount('bookmarks');
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.partials.bookmark-button');
    }
}
