<?php

namespace Modules\Forms\Models;

use App\Models\Team;
use App\Models\TeamApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'team_id',
        'user_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teamApplication()
    {
        return $this->hasOne(TeamApplication::class);
    }
}
