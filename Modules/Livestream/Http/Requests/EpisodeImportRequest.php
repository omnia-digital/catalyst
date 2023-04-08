<?php

namespace Modules\Livestream\Http\Requests;

/**
 * Handles Importing Episodes from another provider
 *
 * Class EpisodeImportRequest
 */
class EpisodeImportRequest extends ImportRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'import_path' => 'required | string',
            'import_type' => 'required | string',
            'provider' => 'required | string',
        ];
    }
}
