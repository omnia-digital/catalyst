<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Modules\Social\Models\Post;

class BookmarkButton extends Component
{
    public Post $model;

    public bool $show = false;

    public function toggleBookmark()
    {
        $this->model->isBookmarkedBy()
            ? $this->model->removeBookmark()
            : $this->model->markAsBookmark();

        $this->model->refresh();
        $this->model->loadCount('bookmarks');
    }

    public function render()
    {
        return view('social::livewire.partials.bookmark-button');
    }
}
