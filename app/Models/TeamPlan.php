<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @note We are not using this currently. Save for future when we want teams to create custom plans */
class TeamPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function prices(): HasMany
    {
        return $this->hasMany(TeamPlanPrice::class);
    }
}
