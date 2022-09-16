<?php

namespace Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormAssemblyField extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function booted()
    {
        static::saving(function (self $field) {
            $field->name = strtolower($field->name);
        });
    }

    public function formAssemblyForm(): BelongsTo
    {
        return $this->belongsTo(FormAssemblyForm::class);
    }
}
