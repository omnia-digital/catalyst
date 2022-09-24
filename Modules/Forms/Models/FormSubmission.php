<?php

namespace Modules\Forms\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'team_id',
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
}
