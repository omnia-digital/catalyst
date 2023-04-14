<?php

namespace Modules\Feeds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Feeds\Enums\FeedSourceType;

class FeedSource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => FeedSourceType::class,
    ];
}
