<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Models\User;
use Livewire\Component;

class FollowButton extends Component
{
    public $model;

    public function mount($model)
    {
        $this->model = $model;
    }
    public function follow()
    {
        $this->authUser->toggleFollow($this->model);
    }

    public function getAuthUserProperty()
    {
        return User::find(auth()->id());
    }

    public function getCountProperty()
    {
        return $this->model->followables()->count();
    }

    public function render()
    {
        return view('social::livewire.partials.follow-button');
    }
}
