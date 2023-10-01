<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Set the credentials JSON's location to use assert credentials, otherwise
    | app engine or compute engine will be used.
    |
    */
    'service' => [

        /*
         * Path to service account json file. You can also pass the credentials as an array
         * instead of a file path.
         */
        'file' => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION', ''),
    ],
];
