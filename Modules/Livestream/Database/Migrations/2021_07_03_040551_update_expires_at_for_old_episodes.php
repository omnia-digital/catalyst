<?php

use Modules\Livestream\Models\Episode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;

class UpdateExpiresAtForOldEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Episode::with('livestreamAccount.team', 'livestreamAccount.team.subscriptions')
            ->where(fn(Builder $query) => $query->whereNull('expires_at')->orWhere('expires_at', ''))
            ->get()
            ->each(function (Episode $episode) {
                $episodeExpiration = $episode->livestreamAccount->team->sparkPlan()?->options['episode_expiration'];

                if ($episodeExpiration) {
                    $episode->update(['expires_at' => $episode->created_at->addDays($episodeExpiration)]);
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
        //
    }
}
