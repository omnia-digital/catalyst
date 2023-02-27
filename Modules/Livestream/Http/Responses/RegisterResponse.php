<?php

namespace Modules\Livestream\Http\Responses;

use Modules\Livestream\Models\Team;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $team = Team::where('user_id', $request->user()->id)->first();

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->route('teams.show', [
                'team' => $team,
                'alert' => true,
                'registered' => true
            ]);
    }
}
