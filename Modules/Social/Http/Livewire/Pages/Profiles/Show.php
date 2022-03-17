<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;

class Show extends Component
{
    public $profile;
    public $recentlyAddedComment;

    public function postAdded(Post $post) {
        $this->recentlyAddedComment = $post;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.show');
    }
}
