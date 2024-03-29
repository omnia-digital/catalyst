<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'view_start' => 'datetime',
        'view_end' => 'datetime',
    ];
}
