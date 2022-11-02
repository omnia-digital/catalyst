<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Form extends Model
{
    use HasFactory, HasSlug;

    protected $casts = [
        'content' => 'array',
    ];

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }

    public function formTemplate()
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function formType()
    {
        return $this->belongsTo(FormType::class);
    }

    public static function getRegistrationForm()
    {
        $formType = FormType::where('slug', 'registration')->first();

        if($formType) {
            return self::where('form_type_id', $formType?->id)->first();
        }

        return false;
    }

}
