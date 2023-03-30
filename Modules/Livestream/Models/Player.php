<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Player extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'livestream_account_id',
        'embedCode',
        'not_live_image',
        'before_live_image',
        'layout',
    ];

    protected $casts = [
        'layout' => 'array',
    ];

    /**
     * Get the layout setting of a specific player.
     *
     * @return mixed
     */
    public function layoutSetting(string $field)
    {
        return $this->layout[$field] ?? config('omnia.player.default_layout.' . $field);
    }

    /**
     * Get all layout settings.
     *
     * @return array
     */
    public function layoutSettings()
    {
        return array_merge(config('omnia.player.default_layout', []), $this->layout ?? []);
    }

    /**
     * Get Livestream Account default image if this image is null
     *
     * @param $value
     * @return string|null
     */
    public function getNotLiveImageUrlAttribute()
    {
        if (Str::startsWith($this->not_live_image, ['http', 'https'])) {
            return $this->not_live_image;
        }

        if (! empty($this->not_live_image)) {
            return Storage::disk('players')->url($this->not_live_image);
        }

        return $this->livestreamAccount?->notLiveImageUrl;
    }

    /**
     * Get Livestream Account default image if this image is null
     *
     * @param $value
     * @return string|null
     */
    public function getBeforeLiveImageUrlAttribute()
    {
        if (Str::startsWith($this->before_live_image, ['http', 'https'])) {
            return $this->before_live_image;
        }

        if (! empty($this->before_live_image)) {
            return Storage::disk('players')->url($this->before_live_image);
        }

        return $this->livestreamAccount?->beforeLiveImageUrl;
    }

    /**
     * @return string
     */
    public function getEmbedPlayerUrlAttribute()
    {
        return config('livestream.embed_player_url') . $this->livestream_account_id . '/' . $this->id;
    }

    public function livestreamAccount()
    {
        return $this->belongsTo(LivestreamAccount::class);
    }
}
