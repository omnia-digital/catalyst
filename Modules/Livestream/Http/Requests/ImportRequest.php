<?php

namespace App\Http\Requests;

/**
 * Class ImportRequest
 * @package App\Http\Requests
 */
class ImportRequest extends LivestreamRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}
