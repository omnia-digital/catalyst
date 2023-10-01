<?php

namespace Modules\Livestream\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Laravel\Spark\Repositories\LivestreamAccountRepository;
use Modules\Livestream\Account;
use Modules\Livestream\Http\Requests\LivestreamAccountRequest;
use Modules\Livestream\Interactions\DeleteLivestreamAccountImage;
use Modules\Livestream\Interactions\UpdateLivestreamAccountImage;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Omnia;
use Modules\Livestream\Repositories\StreamRepository;

class LivestreamAccountController extends LivestreamController
{
    /**
     * Return all livestream accounts
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // check if this user access to do this
        $this->middleware('dev');

        return LivestreamAccount::all();
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param  Request|LivestreamAccountRequest  $request
     * @return Response
     *
     * @throws Exception
     */
    public function store(LivestreamAccountRequest $request)
    {
        DB::beginTransaction();
        try {
            // @TODO [Josh] - might need to create Wowza live source publishers during this process so people can't publish live streams to other accounts
            // @TODO [Josh] - https://www.wowza.com/forums/content.php?742-Live-sources-query-examples#getpublishers
            // Check to make sure that this Account doesn't already have a LivestreamAccount
            // @TODO [Josh] - this check should be moved to the validation in the account request class
            if ($this->_livestreamAccount !== null) {
                throw new Exception('This Account already has a Livestream Account');
            }
            $user = auth()->user();
            $request = $request->all();
//            $vhost = WowzaVhost::find(1); // @TODO [Josh] - need to figure out how to find the correct one, this is currently hard coded
//            $wowzaMediaServer = WowzaMediaServer::find(2);

            $admin_email = (! empty($request['admin_email'])) ? $request['admin_email'] : $this->_user->email;
            $LivestreamAccount_data = [
                'admin_email' => $admin_email,
                'team_id' => $user->currentTeam()->id,
            ];
            $LivestreamAccount_data = array_merge($request, $LivestreamAccount_data);
            $livestreamAccount = Omnia::interact(LivestreamAccountRepository::class . '@create',
                [$user, $LivestreamAccount_data]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Failed to Create Livestream Account: ' . $e->getMessage());
        }

        DB::commit();

        return $livestreamAccount;
    }

    /**
     * Display the specified resource.
     *
     *
     * @return LivestreamAccount
     */
    public function show(Request $request, LivestreamAccount $livestreamAccount)
    {
        $team = $livestreamAccount->team;
        $activeTeamPlans = $team->activePlans(true);
        $response = collect($livestreamAccount);
        if ($activeTeamPlans instanceof SupportCollection && $activeTeamPlans->isNotEmpty() && $activeTeamPlans->has('livestream')) {
            $response->put('activePlan', $activeTeamPlans->get('livestream')->id);
        }

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LivestreamAccountRequest|Request  $request
     * @return Response
     */
    public function update(LivestreamAccountRequest $request, LivestreamAccount $livestreamAccount)
    {
        // If we are setting Mux Livestream active, make sure a stream exists for this account on Mux
        if ($livestreamAccount->mux_livestream_active === false && $request->filled('mux_livestream_active')) {
            $mux_livestream_active = $request->get('mux_livestream_active');
            if ($mux_livestream_active === true) {
                $defaultStream = $livestreamAccount->default_stream;
                if (empty($defaultStream)) {
                    $stream = Omnia::interact(StreamRepository::class . '@create', [$livestreamAccount]);
                    if (empty($stream)) {
                        throw new Exception('Could not find Stream for this LivestreamAccount and could not create one');
                    }
                }
            }
        }

        $livestreamAccount->update($request->all());

        return $livestreamAccount;
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $count = Account::destroy($id);

        flash('Livestream Account deleted: ' . $count);

        return $count;
    }

    /**
     * Update the image on given Livestream Account
     *
     *
     * @return mixed
     */
    public function storeImage(Request $request, LivestreamAccount $livestreamAccount, $imageType)
    {
        return Omnia::interact(UpdateLivestreamAccountImage::class, [$livestreamAccount, $imageType, $request->all()]);
    }

    /**
     * Delete the image file and remove from Livestream Account
     *
     * @return mixed
     */
    public function removeImage(LivestreamAccount $livestreamAccount, $imageType)
    {
        return Omnia::interact(DeleteLivestreamAccountImage::class, [$livestreamAccount, $imageType]);
    }
}
