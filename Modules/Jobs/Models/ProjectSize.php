<?php

namespace Modules\Jobs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSize extends Model
{
    use HasFactory;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'title', 1: 'description', 2: 'order'}
     */
    protected $fillable = [
        'title',
        'description',
        'order',
    ];

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\HasManyThrough<User>
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, Job::class, 'user_id', 'id');
    }
}
