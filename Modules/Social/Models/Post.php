<?php

namespace Modules\Social\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Social\Database\Factories\PostFactory;
use Modules\Social\Traits\Attachable;
use Modules\Social\Traits\Bookmarkable;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;

class Post extends Model
{
    use HasFactory, Likable, Postable, Attachable, Bookmarkable;

    protected $fillable = ['user_id', 'team_id', 'title', 'type', 'body', 'postable_id', 'postable_type'];

    protected static function booted()
    {
        static::addGlobalScope('parent', function (Builder $builder) {
            $builder->whereNull('postable_id');
        });
    }

    public function getMainImageAttribute($value)
    {
        if (empty($value)) {
            return "/storage/images/hero_440_ukraine_conflict_pol2022071201.jpeg";
        } else {
            return $value;
        }
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }
}
