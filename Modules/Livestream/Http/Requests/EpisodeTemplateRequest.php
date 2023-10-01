<?php

namespace Modules\Livestream\Http\Requests;

class EpisodeTemplateRequest extends LivestreamRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if (Auth::attempt(['module_livestream_active' => 'Y'])) {
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
        // @TODO [Josh] - need to add functionality to pass back validation errors before I can enable validation again. Right now it is just failing without telling what the reason is, so it's too hard to debug.
        return [];
//        return [
//        	'template_title' => 'required | min:4',
//            'episode_title' => 'required | min:5',
//        ];
    }
}
