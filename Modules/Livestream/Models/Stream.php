<?php namespace Modules\Livestream\Models;

use Modules\Livestream\Enums\StreamStatus;
use Modules\Livestream\Services\Mux\MuxLivestream;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Stream extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_streams';

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'stream_id',
        'stream_key',
        'rtmp_url',
        'reconnect_window',
        'status',
        'active_episode_id',
        'livestream_account_id',
        'default_playback_id',
        'is_active'
    ];

    protected static function booted()
    {
        static::deleting(function (self $stream) {
            app(MuxLivestream::class)->instance()->disableLiveStream($stream->stream_id);
        });
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    public function playbackIds(): MorphMany
    {
        return $this->morphMany(PlaybackId::class, 'playbackable');
    }

    public function streamTargets(): HasMany
    {
        return $this->hasMany(StreamTarget::class);
    }

    /**
     * Mark the stream as idle.
     *
     * @return $this
     */
    public function markAsIdle(): self
    {
        DB::transaction(function () {
            // Find the live now episode.
            $episode = Episode::find($this->active_episode_id);

            // Need to set the stream status to idle
            $this->update([
                'status'            => StreamStatus::IDLE,
                'active_episode_id' => null
            ]);

            // Set the episode is_live_now to false
            $episode && $episode->update(['is_live_now' => false]);
        });

        return $this;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function disable(): self
    {
        DB::transaction(function () {
            $this->update(['is_active' => false]);

            app(MuxLivestream::class)->instance()->disableLiveStream($this->stream_id);
        });

        return $this;
    }

    public function enable(): self
    {
        DB::transaction(function () {
            $this->update(['is_active' => true]);

            app(MuxLivestream::class)->instance()->enableLiveStream($this->stream_id);
        });

        return $this;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isDisabled(): bool
    {
        return !$this->is_active;
    }
}
