<?php

namespace Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormAssemblyForm extends Model
{
    use HasFactory;

    protected $fillable = [];

    public static function findByFormID($formAssemblyFormID)
    {
        return self::where('fa_form_id', $formAssemblyFormID)->first();
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormAssemblyField::class);
    }
}
