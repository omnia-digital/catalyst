<?php

namespace Modules\Social\Http\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasLikedNotification;

class LikeButton extends Component
{
    public $model;

    public $show;
    
    public $hideCount;

    public function mount($model, $show = false, $hideCount = false)
    {
        $this->model = $model;
        $this->show = $show;
        $this->hideCount = $hideCount;
    }

    public function like()
    {
        $this->model->like();

        if ($this->model->refresh()->is_liked) {
            $this->model->user->notify(new PostWasLikedNotification($this->model, Auth::user()));
        }
    }

    public function render()
    {
        return view('social::livewire.partials.like-button');
    }
}
