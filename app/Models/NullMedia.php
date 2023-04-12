<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;

class NullMedia
{
    public $id = 0;

    public $type;

    public function __construct($type = 'team')
    {
        $this->type = $type;
    }

    public function count()
    {
        return 0;
    }

    public function first()
    {
        return $this;
    }

    public function getFullUrl()
    {
        switch ($this->type) {
            case 'profile':
                return URL::asset('storage/images/profile_default.jpg');
                break;

            default:
                return URL::asset('storage/images/team_default.jpg');
                break;
        }
    }
}
