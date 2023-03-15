<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ApplyType extends Model
{
    use Sushi;

    protected $rows = [
        [
            'code' => 'link',
            'name' => 'Link',
        ],
        [
            'code' => 'email',
            'name' => 'Email',
        ],
    ];
}
