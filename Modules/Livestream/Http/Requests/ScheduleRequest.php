<?php

namespace Modules\Livestream\Http\Requests;

use Illuminate\Support\Facades\Auth;

class ScheduleRequest extends LivestreamRequest
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
            //            'account_name' => 'required | min:3',
            //            'account_email'  => 'required | min:3',
        ];
    }
}
