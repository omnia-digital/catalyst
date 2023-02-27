<?php namespace App\Support\Episode;

use App\Models\Episode;
use App\Models\LivestreamAccount;
use App\Models\Player;
use App\Support\Livewire\WithCachedRows;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property Player $player
 * @property Builder $episodesQuery
 * @property Collection $episodes
 */
trait WithEpisodeList
{
    use WithCachedRows;

    public array $layout = [];

    public ?Episode $currentEpisode = null;

    public function mountWithEpisodeList()
    {
        $this->layout = $this->player->layoutSettings();
        $this->currentEpisode = $this->episodes->first();
    }

    public function selectEpisode($episodeId)
    {
        $this->currentEpisode = Episode::find($episodeId);
    }

    public function getEpisodesQueryProperty()
    {
        return $this->player
            ->livestreamAccount
            ->episodes()
            ->with(['livestreamAccount', 'video', 'video.playbackIds', 'mainSpeaker'])
            ->withCount('videoViews')
            ->published()
            ->orderBy('date_recorded', 'desc');
    }

    public function getEpisodesProperty()
    {
        return $this->cache(function () {
            return $this->episodesQuery->paginate($this->player->layoutSetting('video_per_page') + 1);
        });
    }
}
