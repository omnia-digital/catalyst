<?php

namespace Modules\Social\Http\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasBookmarkedNotification;

class BookmarkButton extends Component
{
    public Post $model;
}
