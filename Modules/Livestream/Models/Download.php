<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'downloadable_type',
        'downloadable_id',
        'count'
    ];

    public function downloadable(): MorphTo
    {
        return $this->morphTo();
    }
}
