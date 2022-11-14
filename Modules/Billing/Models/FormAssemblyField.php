<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormAssemblyField extends Model
{
    use HasFactory;

    protected $guarded = [];
    
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
