<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Social\Traits\Schedulable;

class TeamNotification extends Model
{
    use HasFactory, Schedulable;

    protected $guarded = [];
    
    /* protected static function newFactory()
    {
        return \Modules\Social\Database\factories\TeamNotificationFactory::new();
    } */


}
