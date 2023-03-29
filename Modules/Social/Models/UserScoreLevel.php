<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserScoreLevel extends Model
{
    use HasFactory;

    protected $fillable = ['min_points', 'name'];
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\UserScoreLevelFactory::new();
    }   
}
