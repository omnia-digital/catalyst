<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
