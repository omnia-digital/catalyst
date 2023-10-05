<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OmniaDigital\CatalystCore\Models\Team as CatalystTeam;

/**
 * Teams are just Teams
 */
class Team extends CatalystTeam
{
    use HasFactory;
//    use HasJobs;
//use Reviewable

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'handle',
        'start_date',
        'summary',
        'content',
        'stripe_connect_id',
        'stripe_connect_onboarding_completed',
    ];

}

