<?php namespace App\Models;

use App\Traits\InteractsWithTopic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Tags\HasTags;

class EpisodeTemplate extends Model
{
    use HasFactory, HasTags, InteractsWithTopic;

    protected $table = 'livestream_episode_templates';

    protected $fillable = [
        'title',
        'description',
        'template',
        'livestream_account_id',
        'default_thumbnail'
    ];

    protected $casts = [
        'template' => 'array'
    ];

    public function getDefaultThumbnailUrlAttribute()
    {
        if (!$this->default_thumbnail) {
            return null;
        }

        return Storage::disk('episode-templates')->url($this->default_thumbnail);
    }

    public function livestreamAccount(): BelongsTo
    {
        return $this->belongsTo(LivestreamAccount::class);
    }

    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class, 'livestream_episode_template_series');
    }
}
