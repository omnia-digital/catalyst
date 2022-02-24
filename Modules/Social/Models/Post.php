<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Likable;

    protected $fillable = ['title', 'body'];
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\PostFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
