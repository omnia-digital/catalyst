<?php

use Illuminate\Database\Migrations\Migration;

class MigrateTeamLogoToS3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Team::query()
            ->whereNotNull('photo_url')
            ->get()
            ->each(function (\App\Models\Team $team) {
                if (\Illuminate\Support\Str::startsWith($team->photo_url, '/storage')) {
                    $team->update(['photo_url' => str_replace('/storage/', '', $team->photo_url)]);
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

    }
}
