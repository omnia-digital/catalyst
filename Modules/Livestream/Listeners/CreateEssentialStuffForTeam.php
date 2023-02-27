<?php

namespace Modules\Livestream\Listeners;

use Modules\Livestream\Actions\Livestream\CreateMuxStreamAction;
use Modules\Livestream\Enums\VideoStorageOption;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Player;
use Modules\Livestream\Models\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Jetstream\Events\TeamCreated;

class CreateEssentialStuffForTeam
{
    /**
     * Handle the event.
     *
     * @param TeamCreated $event
     * @return void
     */
    public function handle(TeamCreated $event)
    {
        $livestreamAccount = $this->createLivestreamAccount($event->team);

        $player = $this->createPlayer($livestreamAccount);

        $this->createChannel($livestreamAccount, $player);

        $this->createDefaultEpisodeTemplate($livestreamAccount);

        $this->setDefaultStreamSetting($livestreamAccount);

        $this->setDefaultStreamSetting($livestreamAccount);

        (new CreateMuxStreamAction)->execute($event->team);
    }

    protected function createLivestreamAccount(Team $team)
    {
        return $team->livestreamAccount()->create([
            'admin_email'          => $team->owner->email,
            'name'                 => 'Default',
            'video_storage_option' => VideoStorageOption::PAY_VIDEO_STORAGE
        ]);
    }

    protected function createPlayer(LivestreamAccount $livestreamAccount)
    {
        return $livestreamAccount->players()->create([
            'name' => 'Default Player'
        ]);
    }

    protected function createChannel(LivestreamAccount $livestreamAccount, Player $player)
    {
        return $livestreamAccount->channels()->create([
            'name'      => $livestreamAccount->name . ' Channel',
            'player_id' => $player->id
        ]);
    }

    protected function createDefaultEpisodeTemplate(LivestreamAccount $livestreamAccount): void
    {
        $episodeTemplate = $livestreamAccount->episodeTemplates()->create([
            'title'       => 'Default Template',
            'description' => '[day_of_week] will be replace by the current day of the week (eg. Sunday)',
            'template'    => [
                'title'       => '[day_of_week] Service',
                'description' => 'Weekly Service'
            ]
        ]);

        $livestreamAccount->update(['default_episode_template_id' => $episodeTemplate->id]);
    }

    protected function setDefaultStreamSetting(LivestreamAccount $livestreamAccount): void
    {
        $livestreamAccount->update([
            'mux_livestream_active'     => true,
            'mux_vod_active'            => true,
            'mux_stream_targets_active' => true
        ]);
    }
}
