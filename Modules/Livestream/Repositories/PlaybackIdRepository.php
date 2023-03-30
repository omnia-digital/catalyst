<?php

namespace Modules\Livestream\Repositories;

use Illuminate\Support\Facades\Config;
use Modules\Livestream\Contracts\Repositories\LivestreamRepositoryContract;
use Modules\Livestream\EpisodeTemplate;
use Modules\Livestream\Module;
use Modules\Livestream\Player;
use Modules\Livestream\Role;
use Modules\Livestream\Services\MuxService;
use Modules\Livestream\Stream;

class PlaybackIdRepository implements LivestreamRepositoryContract
{
    /**
     * Perform a basic Stream search.
     *
     * @param  string  $query
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeStream
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($query, $excludeStream = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Stream::where('id', $id)->with('owner', 'users')->first();
    }

    /**
     * {@inheritdoc}
     */
    public function forLivestreamAccount($livestream_account)
    {
        return $livestream_account->streams;
    }

    /**
     * {@inheritdoc}
     */
    public function create($user, array $data)
    {
        // create a stream on Mux
        $mux_service = new MuxService;

        // then create it on omnia

        $stream = Stream::create($data);
        $module = Module::where('module_slug', Config::get('livestream.module_slug'))->first();
        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Administrator of the account',
            'level' => 1,
            'module_id' => $module->id,
            'team_id' => $data['team_id'],
        ]);
        $user->attachRole($role);

        // Create Default Player
        $player = Player::create([
            'name' => 'Live Player',
            'livestream_account_id' => $stream->id,
        ]);

        // Create Default Episode Template for this account
        $defaultEpisodeTemplate = EpisodeTemplate::getSystemDefault()->replicate();
        $defaultEpisodeTemplate->livestream_account_id = $stream->id;
        $defaultEpisodeTemplate->save();

        $defaultStream = Stream::create();

        $stream->default_episode_template_id = $defaultEpisodeTemplate->id;
        $stream->save();

        return $stream;
    }
}
