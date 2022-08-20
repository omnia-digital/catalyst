<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphToMany<Team>
     */
    public function teams(): \Illuminate\Database\Eloquent\Relations\MorphToMany  
    {
        return $this->morphedByMany(Team::class, 'awardable');
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphToMany<User>
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\MorphToMany  
    {
        return $this->morphedByMany(User::class, 'awardable');
    }
}
