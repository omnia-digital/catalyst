<?php

namespace Modules\Livestream\Http\Requests;

class EpisodeEditRequest extends LivestreamRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($user = auth()->user()) {
            $user->id = $this->user()->id;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // @TODO [Josh] - need to add functionality to pass back validation errors before I can enable validation again. Right now it is just failing without telling what the reason is, so it's too hard to debug.
        return [
            'title' => 'required | min:5',
        ];
    }
}
