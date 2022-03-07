<?php

namespace Modules\Jobs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoursPerWeek extends Model
{
    use HasFactory;

    public $table= "hours_per_week";

    protected $fillable = [
        'value',
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
