<?php namespace App\Models;

use App\Registries\VideoSource\Concerns\HasSourceVideo;
use App\Support\Livestream\Concerns\HasPlayback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;
    use HasSourceVideo;
    use HasPlayback;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestream_videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'episode_id',
        'file_name', // (optional) only use if using server directory paths
        'file_type', // (optional) only use if using server directory paths
        'full_file_path', // (optional) only use if using server directory paths
        'playback_url', // (optional) only override if not using default formatting
        'stream_url', // (optional) for live videos (can be from VideoSourceType)
        'video_source_id', // (optional) external id of video on video source
        'video_source_account_id', // (optional) id of facebook, youtube, etc. account
        'video_source_type_id', // facebook, youtube, etc. from VideoSourceTypes
        'max_width', // (optional)
        'max_height', // (optional)
        'max_frame_rate', // (optional)
    ];

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    public function videoViews(): HasMany
    {
        return $this->hasMany(VideoView::class);
    }

    public function isAudio(): bool
    {
        return $this->file_type === 'mp3';
    }
}
