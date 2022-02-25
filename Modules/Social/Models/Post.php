<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Likable, Postable;

    protected $fillable = ['user_id', 'team_id', 'body', 'postable_id', 'postable_type'];
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\PostFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->morphMany(Post::class, 'postable');
    }

}
