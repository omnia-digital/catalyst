<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Livestream\Enums\VideoStorageOption;

class LivestreamAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'mux_livestream_active' => 'boolean',
        'mux_vod_active' => 'boolean',
        'mux_stream_targets_active' => 'boolean',
    ];

    public function hasDefaultStream(): bool
    {
        return $this->streams()->exists();
    }

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class);
    }

    public function getNotLiveImageUrlAttribute()
    {
        if (! $this->not_live_image) {
            return null;
        }

        if (Str::startsWith($this->not_live_image, ['http', 'https'])) {
            return $this->not_live_image;
        }

        return Storage::disk('players')->url($this->not_live_image);
    }

    public function getBeforeLiveImageUrlAttribute()
    {
        if (! $this->before_live_image) {
            return null;
        }

        if (Str::startsWith($this->before_live_image, ['http', 'https'])) {
            return $this->before_live_image;
        }

        return Storage::disk('players')->url($this->before_live_image);
    }

    public function defaultStream(): ?Stream
    {
        return $this->streams()->first();
    }

    public function episodeTemplates(): HasMany
    {
        return $this->hasMany(EpisodeTemplate::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function streamTargets(): HasManyThrough
    {
        return $this->hasManyThrough(StreamTarget::class, Stream::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Get the default episode template of the given livestream account.
     */
    public function defaultEpisodeTemplate(): ?EpisodeTemplate
    {
        return EpisodeTemplate::find($this->default_episode_template_id);
    }

    /**
     * Check if the livestream account selects auto deletes video option.
     */
    public function isAutoDeletesVideos(): bool
    {
        return $this->video_storage_option === VideoStorageOption::DELETE_VIDEO;
    }

    public function hasEpisodes(): bool
    {
        return $this->episodes()->exists();
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }
}
