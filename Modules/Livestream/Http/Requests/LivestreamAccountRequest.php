<?php

namespace Modules\Livestream\Http\Requests;

class LivestreamAccountRequest extends LivestreamRequest
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
        return [
        ];
    }
}
