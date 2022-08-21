<?php

namespace Modules\Jobs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoursPerWeek extends Model
{
    use HasFactory;

    public string $table= "hours_per_week";

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'value'}
     */
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
}
