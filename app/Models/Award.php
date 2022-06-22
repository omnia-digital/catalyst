<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teams()  
    {
        return $this->morphedByMany(Team::class, 'awardable');
    }

    public function users()  
    {
        return $this->morphedByMany(User::class, 'awardable');
    }
}