<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FormType extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'for',
    ];

    public static function forTeams()
    {
        return self::where('for', 'teams')->get();
    }

    public static function teamApplicationForm()
    {
        return self::where('slug', 'team-member-application-form')->first();
    }

    public static function teamApplicationFormId()
    {
        return self::teamApplicationForm()?->id;
    }

    public static function userRegistrationForm()
    {
        return self::where('slug', 'registration')->first();
    }

    public static function userRegistrationFormId()
    {
        return self::userRegistrationForm()?->id;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // Relationships

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
