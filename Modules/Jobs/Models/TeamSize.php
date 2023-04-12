<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Jobs\Support\HasJobs;

class TeamSize extends Model
{
    use HasFactory, HasJobs;

    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, JobPosition::class, 'user_id', 'id');
    }
}
