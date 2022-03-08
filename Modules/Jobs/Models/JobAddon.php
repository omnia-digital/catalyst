<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAddon extends Model
{
    use HasFactory;

    protected $table = 'job_position_addons';
}
