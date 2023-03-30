<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Livestream\Models\Team;

class UpdatePersonalTeamForOldTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Team::with('owner', 'owner.ownedTeams')
            ->where('personal_team', 0)
            ->get()
            ->each(function (Team $team) {
                $hasPersonalTeam = $team->owner?->personalTeam();

                if (! $hasPersonalTeam) {
                    $team->update(['personal_team' => true]);
                }
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Team::eachById(fn (Team $team) => $team->update(['personal_team' => false]));
    }
}
