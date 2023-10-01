<?php

namespace Modules\Livestream\Http\Requests;

/**
 * Class ImportRequest
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
