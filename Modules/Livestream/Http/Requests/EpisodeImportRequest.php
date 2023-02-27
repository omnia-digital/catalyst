<?php

namespace App\Http\Requests;

/**
 * Handles Importing Episodes from another provider
 *
 * Class EpisodeImportRequest
 * @package App\Http\Requests
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
            'provider' => 'required | string'
        ];
    }
}
