<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Mention extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\MentionFactory::new();
    }

    public function mentionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function poster()
    {
        return $this->hasOneThrough(User::class, Post::class);
    }
}
