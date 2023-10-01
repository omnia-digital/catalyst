<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Series extends Model
{
    use HasFactory;

    protected $table = 'series';

    protected $guarded = [];

    protected $appends = [
        //        'episode_views'
    ];

    public function episodeTemplates(): BelongsToMany
    {
        return $this->belongsToMany(EpisodeTemplate::class, 'livestream_episode_template_series');
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    public function getEpisodeViewsAttribute()
    {
        return $this->getTotalEpisodeViews();
    }

    public function getTotalEpisodeViews()
    {
        return $this->episodes()->withCount('videoViews')->get()->sum('video_views_count');
    }

    public function episodes(): BelongsToMany
    {
        return $this->belongsToMany(Episode::class, 'livestream_episode_series');
    }

    public function getTotalEpisodeViewsByDateRange($from, $to)
    {
        return $this->episodes()->withCount([
            'videoViews' => function ($query) use ($from, $to) {
                $query->whereBetween('video_views.created_at', [$from, $to]);
            },
        ])->get()->sum('video_views_count');
    }
}
