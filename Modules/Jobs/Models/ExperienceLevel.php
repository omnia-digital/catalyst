<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ExperienceLevel extends Model
{
    use Sushi;

    protected $rows = [
        [
            'id'          => 0,
            'title'       => 'Entry',
            'description' => 'Looking for someone relatively new to this field',
        ],
        [
            'id'          => 1,
            'title'       => 'Intermediate',
            'description' => 'Looking for substantial experience in this field',
        ],
        [
            'id'          => 2,
            'title'       => 'Expert',
            'description' => 'Looking for comprehesive and deep expertise in this field',
        ]
    ];

}
