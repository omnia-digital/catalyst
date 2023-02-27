<?php namespace Modules\Livestream\Http\Controllers\Api;

use Modules\Livestream\Http\Controllers\Controller;
use Modules\Livestream\Models\Player;
use Illuminate\Pagination\LengthAwarePaginator;

class EmbedPlayersController extends Controller
{
    public function load(Player $player)
    {
        $episodes = $this->getEpisodes($player);

        return view('episode.embed', [
            'episodes'       => $episodes,
            'initialEpisode' => $episodes->first(),
            'player'         => $player
        ]);
    }

    public function loadGallery(Player $player)
    {
        $episodes = $this->getEpisodes($player);

        return view('episode.embed-gallery', [
            'episodes'       => $episodes,
            'initialEpisode' => $episodes->first(),
            'player'         => $player
        ]);
    }

    protected function getEpisodes(Player $player): LengthAwarePaginator
    {
        return $player->livestreamAccount
            ->episodes()
            ->with(['video', 'video.playbackIds', 'livestreamAccount'])
            ->withCount('videoViews')
            ->published()
            ->orderBy('date_recorded', 'desc')
            ->paginate($player->layoutSetting('video_per_page'));
    }
}
