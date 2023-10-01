<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Trans;

class Like extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];
    protected $fillable = ['user_id', 'likable_id', 'likable_type', 'liked', 'deleted_at', 'created_at', 'updated_at'];

    public function actor()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function toText($type = 'post')
    {
        $actorName = $this->actor->handle;
        $msg = $type == 'post' ? Trans::get('notification.likedPhoto') : Trans::get('notification.likedComment');

        return "{$actorName} " . $msg;
    }

    public function toHtml($type = 'post')
    {
        $actorName = $this->actor->handle;
        $actorUrl = $this->actor->url();
        $msg = $type == 'post' ? Trans::get('notification.likedPhoto') : Trans::get('notification.likedComment');

        return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . $msg;
    }

    public function likable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id', 'likable_id');
    }
}
