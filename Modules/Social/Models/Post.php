<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Social\Database\Factories\PostFactory;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;

class Post extends Model
{
    use HasFactory, Likable, Postable, Attachable;

    protected $fillable = ['user_id', 'team_id', 'type', 'body', 'postable_id', 'postable_type'];

    protected static function newFactory()
    {
        return PostFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->morphMany(Post::class, 'postable');
    }
}
