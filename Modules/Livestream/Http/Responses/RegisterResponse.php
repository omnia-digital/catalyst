<?php

namespace Modules\Livestream\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Modules\Livestream\Models\Team;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return Response
     */
    public function toResponse($request)
    {
        $team = Team::where('user_id', $request->user()->id)->first();

        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->route('teams.show', [
                'team' => $team,
                'alert' => true,
                'registered' => true,
            ]);
    }
}
