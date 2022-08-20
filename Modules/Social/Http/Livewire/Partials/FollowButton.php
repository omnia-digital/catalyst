<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\Social\Notifications\NewFollowerNotification;

/**
 * @property User $authUser
 */
class FollowButton extends Component
{
    public Model $model;

    public function mount($model): void
    {
        $this->model = $model;
    }

    public function follow(): void
    {
        if ($this->authUser->isFollowing($this->model)) {
            $this->authUser->unfollow($this->model);
        } else {
            $this->authUser->follow($this->model);

            $this->model->notify(new NewFollowerNotification($this->authUser));
        }
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection<User>
     */
    public function getAuthUserProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return User::find(auth()->id());
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.partials.follow-button');
    }
}
