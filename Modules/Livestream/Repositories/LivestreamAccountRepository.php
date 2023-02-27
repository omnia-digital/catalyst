<?php

namespace Modules\Livestream\Repositories;

use Modules\Livestream\Module;
use Modules\Livestream\Omnia;
use Modules\Livestream\Role;
use Modules\Livestream\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Spark\Spark;
use Laravel\Spark\Events\PaymentMethod\VatIdUpdated;
use Laravel\Spark\Events\PaymentMethod\BillingAddressUpdated;
use Modules\Livestream\Contracts\Repositories\LivestreamRepositoryContract;
use Modules\Livestream\EpisodeTemplate;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Player;
use Modules\Livestream\Stream;

class LivestreamAccountRepository implements LivestreamRepositoryContract
{
    /**
     * Perform a basic LivestreamAccount search by name or e-mail address.
     *
     * @param  string  $query
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeLivestreamAccount
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($query, $excludeLivestreamAccount = null){}

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Spark::LivestreamAccount()->with('owner', 'users')->where('id', $id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function forUser($user)
    {
        return $user->LivestreamAccounts();
    }

    /**
     * {@inheritdoc}
     */
    public function create($user,array $data)
    {
        $livestream_account = LivestreamAccount::create($data);
        $module = Module::where('module_slug', Config::get('livestream.module_slug'))->first();
        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Administrator of the account',
            'level' => 1,
            'module_id' => $module->id,
            'team_id' => $data['team_id']
        ]);
        $user->attachRole($role);

	    // Create Default Player
        $player = Player::create([
            'name' => 'Live Player',
            'livestream_account_id' => $livestream_account->id
        ]);

	    // Create Default Episode Template for this account
	    $default_episode_template = EpisodeTemplate::getSystemDefault()->replicate();
	    $default_episode_template->livestream_account_id = $livestream_account->id;
	    $default_episode_template->save();

        $stream = Omnia::interact(StreamRepository::class.'@create', [$livestream_account]);
        $livestream_account->mux_livestream_active = true;
        $livestream_account->mux_vod_active = true;
        $livestream_account->mux_stream_targets_active = true;
        $livestream_account->default_episode_template_id = $default_episode_template->id;
        $livestream_account->save();
        return $livestream_account;
    }
}
