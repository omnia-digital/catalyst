<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $guarded = [];

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
