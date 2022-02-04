<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["title","description","image"];
    
    protected static function newFactory()
    {
        return \Modules\Projects\Database\factories\ProjectFactory::new();
    }
}
