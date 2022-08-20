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

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\HasManyThrough<User>
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, Job::class, 'user_id', 'id');
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\HasMany<Job>
     */
    public function jobs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Job::class);
    }
}
