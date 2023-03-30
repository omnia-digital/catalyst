<?php

namespace Modules\Livestream\Http\Controllers\Api;

use Modules\Livestream\Http\Controllers\Controller;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\Person;
use Modules\Livestream\Models\Playlist;
use Modules\Livestream\Models\Series;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

class EmbedPlaylistController extends Controller
{
    public function index(Playlist $playlist, Request $request)
    {
        $data = $request->all();

        $episodes = Episode::query()
            ->with(['mainSpeaker', 'video', 'video.playbackIds', 'livestreamAccount.team', 'series', 'media', 'staticMedia', 'tags', 'category'])
            ->withCount(['videoViews'])
            ->where('livestream_account_id', $playlist->livestream_account_id)
            ->when(Arr::get($data, 'search'), fn (Builder $query, $search) => $query->where('title', 'LIKE', "%$search%"))
            ->when(Arr::get($data, 'speaker'), fn (Builder $query, $speaker) => $query->where('main_speaker_id', $speaker))
            ->when(Arr::get($data, 'series'), fn (Builder $query, $series) => $query->whereHas('series', fn (Builder $query) => $query->where('series_id', $series)))
            ->when(Arr::get($data, 'topics'), fn (Builder $query, $topics) => $query->whereHas('tags', fn (Builder $query) => $query->where('tag_id', $topics)->where('type', 'topic')))
            ->latest('date_recorded')
            ->paginate($playlist->per_page);

        return view('playlist.embed.index', [
            'episodes' => $episodes,
            'speakers' => $this->getSpeakers($playlist),
            'series'   => $this->getSeries($playlist),
            'topics'   => $this->getTopics(),
        ]);
    }

    private function getSpeakers(Playlist $playlist): Collection
    {
        return Person::select(['first_name', 'last_name', 'id'])
            ->whereIn('id', Episode::where('livestream_account_id', $playlist->livestream_account_id)->pluck('main_speaker_id'))
            ->get()
            ->pluck('name', 'id');
    }

    private function getSeries(Playlist $playlist): Collection
    {
        return Series::query()
            ->where('livestream_account_id', $playlist->livestream_account_id)
            ->pluck('name', 'id');
    }

    private function getTopics(): Collection
    {
        return Tag::withType('topic')
            ->pluck('name', 'id');
    }
}
