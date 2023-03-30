<?php

use Illuminate\Database\Migrations\Migration;

class CreateChannelsForOldAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\LivestreamAccount::with('players')
            ->get()
            ->each(function (App\Models\LivestreamAccount $livestreamAccount) {
                $player = $livestreamAccount->players->first();

                if ($player) {
                    $livestreamAccount->channels()->create([
                        'name' => $livestreamAccount->name . ' Live',
                        'player_id' => $player->id,
                    ]);
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
