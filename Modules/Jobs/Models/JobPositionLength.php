<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class JobPositionLength extends Model
{
    use Sushi;

    protected $rows = [
        [
            'id' => 0,
            'title' => 'more-than-6-months',
            'description' => 'More than 6 months',
        ],
        [
            'id' => 1,
            'title' => '3-6-months',
            'description' => '3 to 6 months',
        ],
        [
            'id' => 2,
            'title' => '1-3-months',
            'description' => '1 to 3 months',
        ],
    ];
}
