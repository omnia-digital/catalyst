<?php

namespace Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FormAssemblyForm extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public static function findBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }

    public static function findByFormID($formAssemblyFormID)
    {
        return self::where('fa_form_id', $formAssemblyFormID)->first();
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormAssemblyField::class);
    }
}
