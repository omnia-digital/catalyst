<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Social\Database\factories\UserScoreLevelFactory;

class UserScoreLevel extends Model
{
    use HasFactory;

    protected $fillable = ['min_points', 'name', 'level'];

    protected static function newFactory()
    {
        return UserScoreLevelFactory::new();
    }
}
