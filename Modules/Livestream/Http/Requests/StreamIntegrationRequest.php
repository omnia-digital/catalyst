<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class StreamIntegrationRequest extends LivestreamRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    return true;
//	    $request_team_id = (int)$this->request->all();
//	    $current_team_id = (int)Auth::user()->currentTeam()->id;
//        if ( $request_team_id === $current_team_id) {
//            return true;
//        } else {
//            return false;
//        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enabled'                   => 'required',
        	'provider'                  => 'required | string',
            'provider_team_object.id'   => 'required',
	        'livestream_account_id'     => 'required | integer'
        ];
    }
}
