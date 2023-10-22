<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Team as JetstreamTeam;
use OmniaDigital\CatalystCore\Models\Team as CatalystTeam;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Searchable\Searchable;
use OmniaDigital\CatalystCore\Traits\CatalystTeamTraits;

/**
 * Teams are just Teams
 */
class Team extends JetstreamTeam implements HasMedia, Searchable
{
    use HasFactory;
    use CatalystTeamTraits;

}

