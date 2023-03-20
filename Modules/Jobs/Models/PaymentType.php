<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class PaymentType extends Model
{
    use Sushi;

    protected $rows = [
        [
            'code' => 'hourly',
            'name' => 'Hourly',
        ],
        [
            'code' => 'fixed',
            'name' => 'Fixed',
        ],
    ];
}
