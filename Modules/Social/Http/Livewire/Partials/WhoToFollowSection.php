<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Models\User;
use Livewire\Component;

class WhoToFollowSection extends Component
{
    public function getUsersQueryProperty()
    {
        return User::query();
    }

    public function getTrendingUsersProperty()
    {
        return $this
            ->usersQuery
            ->leftJoin('user_follower', 'user_follower.following_id', 'users.id')
            ->whereMonth('user_follower.created_at', now()->month)
            ->orderByFollowersCountDesc()
            ->distinct()
            ->limit(3)->get();
    }

    public function render()
    {
        return view('social::livewire.partials.who-to-follow-section');
    }
}
