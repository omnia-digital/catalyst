<?php

namespace Modules\Games\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Social\Models\Association;

// This is our own custom game model so we can use relations, but we can get the details from igdb still
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'igdb_id',
        'name',
        'slug'
    ];

    public function getDetailsAttribute()
    {
        return $this->igdbDetails;
    }

    public function getIgdbDetailsAttribute()
    {
        return IGDB\Game::where('id', $this->igdb_id)->first();
    }

    //** Relations **//
    public function associations()
    {
        return $this->hasMany(Association::class);
    }
}
