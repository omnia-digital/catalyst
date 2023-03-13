<?php

namespace Modules\Jobs\Models;

use Modules\Jobs\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, Job::class, 'user_id', 'id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
