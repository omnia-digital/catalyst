<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /* protected static function newFactory()
    {
        return \Modules\Social\Database\factories\AttachmentFactory::new();
    } */
}