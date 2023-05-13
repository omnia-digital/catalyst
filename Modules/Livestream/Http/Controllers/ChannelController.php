<?php

namespace Modules\Livestream\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Exceptions\ChannelNotFoundException;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Repositories\EpisodeRepository;
use Modules\Livestream\Services\PlayerService;
use Modules\Livestream\Team;
use Omnia;

class ChannelController extends LivestreamController
{
    public function index()
    {
        $result = collect();
        $items = collect();
        $items->put('name', $this->_livestreamAccount->name . ' Live');
        $items->put('id', $this->_livestreamAccount->account_slug);
        $result->push($items);

        return response()->json($result);
    }

    /**
     * Search for Channels
     */
    public function search(Request $request)
    {
        // default filters
        // livestreamAccount must have at least 1 episode
        // team must have a photo_url
        // team.owner doesn't have omnia in email
        // not on the free plan ???

        if ($request->has('query')) {
            $teamName = $request->get('query');
        } else {
            return;
        }

        $livestreamAccounts = LivestreamAccount::has('episodes')->whereHas('team', function ($query) use ($teamName) {
            $query->where('photo_url', '!=', null);
            $query->where('name', 'like', '%' . $teamName . '%');
        })->whereHas('team.owner', function ($query) {
            $query->where('email', 'NOT LIKE', '%omnia%');
        })->with('team')->get();

        return $livestreamAccounts;
    }

    /**
     * Show a channel for a specific Team
     * Return all the Channel Settings for a specific Team
     *
     * @param  int|string  $identifier LivestreamAccountId or slug
     * @return array
     */
    public function show($identifier)
    {
        try {
            $isCurrentlyStreaming = false;
            $bible['code'] = 'niv';
            $playlist = '';
            $errors = collect();

            // Check for LivestreamAccount ID
            if (is_numeric($identifier)) {
                $livestreamAccount = LivestreamAccount::find($identifier);
            } elseif (is_string($identifier)) {
                // Check for LivestreamAccount slug
                $livestreamAccount = LivestreamAccount::where('account_slug', $identifier)->first();
                if (empty($livestreamAccount)) {
                    // Check for Team slug
                    $team = Team::where('team_slug', $identifier)->first();
                    if (! empty($team)) {
                        $livestreamAccount = $team->livestreamAccount;
                    } else {
                        throw new ChannelNotFoundException;
                    }
                }
            } else {
                throw new Exception('Incorrect Type of identifier given. Must be the Id or Slug of the LivestreamAccount or the Team.');
            }

            $playerService = new PlayerService;
            //			$playlist      = $playerService->getPlayerPlaylist( $livestreamAccount );
            // @TODO [Josh] - I need to make sure that the episode has videos to play before showing them. There could be a situation where the episode was created by the StreamEnd event, but the videos haven't been copied over. I need somehow hook in the "VideosFinishedProcessing" event to something so I can check whether to show those videos or not.
            $livestreamAccount->is_live_now = $livestreamAccount->is_live_now;
            $bible['code'] = $livestreamAccount->team->default_bible;

            if (empty($bible['code'])) {
                $bible['code'] = 'niv';
            }
        } catch (Exception $e) {
            if (empty($identifier)) {
                $identifier = '';
            }
            Log::error('Livestream Account: ' . $identifier . ' : ' . $e->getMessage());
            $errors->push($e->getMessage());
            //			$playlist      = $playerService->getPlayerPlaylist( $livestreamAccount );
            // @TODO [Josh] - I need to make sure that the episode has videos to play before showing them. There could be a situation where the episode was created by the StreamEnd event, but the videos haven't been copied over. I need somehow hook in the "VideosFinishedProcessing" event to something so I can check whether to show those videos or not.
            $livestreamAccount->is_live_now = $livestreamAccount->is_live_now;
            $bible['code'] = $livestreamAccount->team->default_bible;
            if (empty($bible['code'])) {
                $bible['code'] = 'niv';
            }
        } catch (Exception $e) {
            Log::error('Livestream Account: ' . $identifier . ' : ' . $e->getMessage());
            $errors->push($e->getMessage());
        }

        $settings = [
            'bible' => $bible,
        ];

        $livestreamAccount->load('default_episode_template');
        $team = $livestreamAccount->team;
        $activeTeamPlans = $team->activePlans(true);
        $activePlanIds = collect();
        if ($activeTeamPlans instanceof Collection && $activeTeamPlans->isNotEmpty()) {
            foreach ($activeTeamPlans as $key => $plan) {
                $activePlanIds->put($key, $plan->id);
            }
        } else {
            $activePlanIds = null;
        }

        $response = [
            'success' => true,
            'data' => [
                'activePlans' => $activePlanIds,
                'livestreamAccount' => $livestreamAccount,
                'settings' => $settings,
                'episodes' => Omnia::interact(EpisodeRepository::class . '@all', [null, $livestreamAccount, true]),
                'errors' => $errors,
            ],
        ];

        return $response;

        //		return view('livestream::channel/show',compact('livestreamAccount','isCurrentlyStreaming','bible','errors'));
    }
}
