<?php

namespace Modules\Livestream\Http\Livewire\Setting;

use Modules\Livestream\Jobs\Episode\DeleteEpisodeJob;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Support\Livewire\WithNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property Team $team
 */
class EpisodeSetting extends Component
{
    use WithNotification;

    public bool $confirmingEpisodesDeletion = false;

    public function deleteAllEpisodes()
    {
        $this->team
            ->livestreamAccount
            ->episodes
            ->each(fn(Episode $episode) => dispatch(new DeleteEpisodeJob($episode)));

        $this->reset('confirmingEpisodesDeletion');
        $this->success('Deleting episodes in the background.');
    }

    public function getTeamProperty()
    {
        return Auth::user()->currentTeam;
    }

    public function render()
    {
        return view('setting.episode-setting')->layout('layouts.setting');
    }
}
