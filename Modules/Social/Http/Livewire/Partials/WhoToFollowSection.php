<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WhoToFollowSection extends Component
{
    public function getUsersQueryProperty()
    {
        return User::query();
    }

    public function getWhoToFollowProperty()
    {
        return $this
            ->usersQuery
            ->withCount(['followers'])
            ->where('id', '<>', Auth::id())
            ->orderBy('followers_count', 'desc')
            ->distinct()
            ->limit(3)->get();
    }

    public function render()
    {
        return view('social::livewire.partials.who-to-follow-section');
    }
}
