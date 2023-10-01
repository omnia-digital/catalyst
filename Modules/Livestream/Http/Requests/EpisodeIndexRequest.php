<?php

namespace Modules\Livestream\Http\Requests;

class EpisodeIndexRequest extends LivestreamRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if ($user = Auth::user()) {
//            $user->id = $this->user()->id;
//            return true;
//        } else {
//            return false;
//        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
