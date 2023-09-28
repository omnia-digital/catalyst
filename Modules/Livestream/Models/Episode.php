<?php

namespace Modules\Livestream\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Livestream\Enums\VideoStorageOption;
use Modules\Livestream\Events\EpisodeCreatedEvent;
use Modules\Livestream\Omnia;
use Modules\Livestream\Services\Mux\MuxAsset;
use Modules\Livestream\Support\Media\InteractsWithStaticMediaUrl;
use Modules\Livestream\Traits\Downloadable;
use Modules\Livestream\Traits\InteractsWithTopic;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Episode extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTags;
    use InteractsWithTopic;
    use InteractsWithStaticMediaUrl;
    use Downloadable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_episodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'date_recorded',
        'livestream_account_id',
        'main_speaker_id',
        'thumbnail',
        'is_published',
        'planned_start_time',
        'main_video_id',
        'max_resolution',
        'default_playback_id',
        'is_live_now',
        'duration',
        'upload_id',
        'expires_at',
        'views',
        'last_viewed_at',
        'main_passage',
        'other_passages',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_live_now' => 'boolean',
        'date_recorded' => 'datetime',
        'planned_start_time' => 'datetime',
        'expires_at' => 'datetime',
        'last_viewed_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => EpisodeCreatedEvent::class,
    ];

    public static function findByUploadId(string $uploadId)
    {
        return self::where('upload_id', $uploadId)->first();
    }

    /**
     * Create episode from template.
     */
    public static function createFromTemplate(array $episodeData): Episode
    {
        if (! empty($episodeData['title'])) {
            Omnia::replaceShortcodesInString($episodeData['title']);
        }

        if (! empty($episodeData['description'])) {
            Omnia::replaceShortcodesInString($episodeData['description']);
        }

        return Episode::create($episodeData);
    }

    public function isLive(): bool
    {
        return (bool) $this->is_live_now;
    }

    public function getThumbnailAttribute($value)
    {
        // Backwards compatible - For absolute file path.
        if (Str::startsWith($value, ['http', 'https'])) {
            return $value;
        }

        // If episode doesn't have a thumbnail, check in the Episode Template -> Team Logo.
        if (empty($value)) {
            $defaultThumbnailFromTemplate = $this->livestreamAccount?->defaultEpisodeTemplate()?->default_thumbnail;

            if ($defaultThumbnailFromTemplate) {
                return Storage::disk('episode-templates')->url($defaultThumbnailFromTemplate);
            }

            if ($teamLogo = $this->livestreamAccount->team->logo) {
                return $teamLogo;
            }

            return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&color=7F9CF5&background=EBF4FF';
        }

        return Storage::disk('episodes')->url($value);
    }

    public function getPlayerThumbnail(Player $player): string
    {
        if (! $this->isLive() && $player->notLiveImageUrl) {
            return $player->notLiveImageUrl;
        }

        if ($this->isLive() && $player->beforeLiveImageUrl) {
            return $player->beforeLiveImageUrl;
        }

        return $this->thumbnail;
    }

    /**
     * Convert duration to HH:MM:SS format.
     *
     * @param $value
     * @return string
     */
    public function getFormattedDurationAttribute()
    {
        if (! $this->duration) {
            return;
        }

        $seconds = $this->duration / 1000;

        return sprintf('%02d:%02d:%02d', ($seconds / 3600), ($seconds / 60 % 60), $seconds % 60);
    }

    public function getViewsAttribute()
    {
        return $this->video_views_count ?? 0;
    }

    public function getSeriesLabelsAttribute()
    {
        return implode(', ', $this->series->pluck('name')->all());
    }

    public function setMainSpeakerIdAttribute($value)
    {
        $this->attributes['main_speaker_id'] = empty($value) ? null : (int) $value;
    }

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = empty($value) ? null : $value;
    }

    public function scopeLivestreamAccount(Builder $query, int|LivestreamAccount $livestreamAccount)
    {
        $livestreamAccountId = $livestreamAccount instanceof LivestreamAccount
            ? $livestreamAccount->id
            : $livestreamAccount;

        return $query->where('livestream_account_id', $livestreamAccountId);
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLiveNow(Builder $query)
    {
        return $query->where('is_live_now', true);
    }

    /**
     * Get the expired episodes for storing based on plan option and expires_at.
     *
     * @return Builder
     */
    public function scopeExpired(Builder $query)
    {
        return $query->whereDate('expires_at', '<', now());
    }

    /**
     * Get all episodes that marked do not store (or not willing to pay for storage).
     *
     * @return Builder
     */
    public function scopeDoNotStore(Builder $query)
    {
        return $query->whereHas(
            'livestreamAccount',
            fn (Builder $query) => $query->where('video_storage_option', VideoStorageOption::DELETE_VIDEO)
        );
    }

    public function scopeShouldBeForceDeleted(Builder $query)
    {
        return $query
            ->onlyTrashed()
            ->whereDate($this->getDeletedAtColumn(), '<=', now()->subDays(config('omnia.video_storage.soft_delete_lasts', 5)));
    }

    public function scopeShouldPullViewsFromMux(Builder $query): Builder
    {
        return $query
            ->whereDate('last_viewed_at', '>=', now()->subHours(config('omnia.pull_views_per_hours') - 1));
        //->orWhereNull('last_viewed_at');
    }

    public function mainSpeaker(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'main_speaker_id');
    }

    public function video(): HasOne
    {
        return $this->hasOne(Video::class);
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class, 'livestream_episode_series');
    }

    public function speakers()
    {
    }

    public function videoViews(): HasManyThrough
    {
        return $this->hasManyThrough(VideoView::class, Video::class);
    }

    public function attachmentDownloads(): HasManyThrough
    {
        return $this->hasManyThrough(Download::class, Media::class, 'model_id', 'downloadable_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeWhereTotalAttachmentDownloadsInDateRange($query, $from, $to)
    {
        return $query->withSum(['attachmentDownloads' => function ($query) use ($from, $to) {
            return $query->whereBetween('downloads.created_at', [$from, $to]);
        }], 'count');
    }

    public function scopeWhereVideoViewsInDateRange($query, $from, $to)
    {
        return $query->withCount(['videoViews' => function ($query) use ($from, $to) {
            $query->whereBetween('video_views.created_at', [$from, $to]);
        }]);
    }

    /**
     * Force delete episode and related stuff.
     */
    public function purge()
    {
        DB::transaction(function () {
            $this->video?->delete();
            $this->series()->delete();
            $this->media->each->delete();

            $this->forceDelete();
        });
    }

    /**
     * Create video + playback ids for the give episode.
     */
    public function createMuxVideo(string $muxVideoSourceId, array $playbackIds): Video
    {
        $video = $this->video()->create([
            'title' => $this->title,
            'video_source_id' => $muxVideoSourceId,
            'video_source_type_id' => 3, // Mux Video Source Type ID.
        ]);

        // Create playback ids.
        $video->playbackIds()->createMany(
            collect($playbackIds)->map(fn (array $playbackId) => [
                'playback_id' => $playbackId['id'],
                'policy' => $playbackId['policy'],
            ])
        );

        // Add MP4 support if needed.
        app(MuxAsset::class)->addAssetMP4Support($muxVideoSourceId);

        return $video;
    }

    public function createMuxAudio(string $muxAudioSourceId, array $playbackIds): Video
    {
        $audio = $this->video()->create([
            'title' => $this->title,
            'video_source_id' => $muxAudioSourceId,
            'file_type' => 'mp3',
            'video_source_type_id' => 3, // Mux Video Source Type ID.
        ]);

        // Create playback ids.
        $audio->playbackIds()->createMany(
            collect($playbackIds)->map(fn (array $playbackId) => [
                'playback_id' => $playbackId['id'],
                'policy' => $playbackId['policy'],
            ])
        );

        return $audio;
    }

    public function toPlayer(?Player $player = null): array
    {
        if (! ($video = $this->video)) {
            return [];
        }

        return [
            'episode_id' => $this->id,
            'video_id' => $video->id,
            'video_title' => $video->title,
            'playback_url' => $video->getPlaybackUrl(),
            'thumbnail' => $player ? $this->getPlayerThumbnail($player) : $this->thumbnail,
            'sub_property_id' => $this->livestreamAccount->id,
            'player_name' => null,
            'player_version' => '2.0.0',
        ];
    }

    public function getTimezone()
    {
        return $this->livestreamAccount->team->timezone;
    }

    public function getStartDatetimeAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getPlannedStartTimeAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getExpiresAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }

    public function getLastViewedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone($this->getTimezone());
    }
}
