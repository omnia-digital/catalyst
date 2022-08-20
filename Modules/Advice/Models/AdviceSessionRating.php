<?php

namespace Advice\App\Models;

use Illuminate\Database\Eloquent\Model;

class AdviceSessionRating extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advice_session_ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'description',
        'advice_profile_id'
    ];

    public function adviceProfile(): void
    {
        $this->belongsTo(AdviceProfile::class);
    }


}
