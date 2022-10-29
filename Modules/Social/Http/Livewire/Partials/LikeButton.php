<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasLikedNotification;

class LikeButton extends Component
{
    use WithGuestAccess;

    public Model $model;

    public $show;

    public $hideCount;

    public $withDislikes;

    public $btnStyles;

    public function mount($model, $show = false, $hideCount = false, $withDislikes = false, $btnStyles = '')
    {
        $this->model = $model;
        $this->show = $show;
        $this->hideCount = $hideCount;
        $this->withDislikes = $withDislikes;
        $this->btnStyles = $btnStyles;
    }

    public function like()
    {
        if (Platform::isAllowingGuestAccess() && !Auth::check()) {
            $this->showAuthenticationModal(route('social.posts.show', $this->model));

            return;
        }

        $this->model->like();

        if ((get_class($this->model) == Post::class) && $this->model->refresh()->is_liked) {
            $this->model->user->notify(new PostWasLikedNotification($this->model, Auth::user()));
        }
    }

    public function dislike()
    {
        $this->model->dislike();

    }

    public function render()
    {
        return view('social::livewire.partials.like-button');
    }
}
