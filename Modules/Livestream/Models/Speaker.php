<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    public function episodes()
    {
        $this->belongsToMany(Episode::class);
    }
}
