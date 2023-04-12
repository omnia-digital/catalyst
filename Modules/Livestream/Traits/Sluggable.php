<?php

namespace Modules\Livestream\Traits;

use Exception;
use Illuminate\Support\Str;

trait Sluggable
{
    use \Larapack\AttributeSlugging\Sluggable;

    /**
     * Adds slug attributes to the dataset, used before saving.
     *
     * @return void
     *
     * @throws Exception
     */
    public function slugAttributes()
    {
        foreach ($this->getSlugAttribute() as $slugAttribute => $sourceAttributes) {
            $slugMaxLength = defined('static::SLUG_MAX_CHAR') ? static::SLUG_MAX_CHAR : 240;
            $this->setSluggedValue($slugAttribute, $sourceAttributes, $slugMaxLength);
        }
    }

    /**
     * Sets a single slug attribute value.
     *
     * @param  string  $slugAttribute    Attribute to populate with the slug.
     * @param  mixed  $sourceAttributes Attribute(s) to generate the slug from.
     *                                 Supports dotted notation for relations.
     * @param  int  $maxLength        Maximum length for the slug not including the counter.
     * @return string The generated value.
     *
     * @throws Exception
     */
    public function setSluggedValue($slugAttribute, $sourceAttributes, $maxLength = 240)
    {
        if (! isset($this->{$slugAttribute}) || ! strlen($this->{$slugAttribute})) {
            if (! is_array($sourceAttributes)) {
                $sourceAttributes = [$sourceAttributes];
            }

            $slugArr = [];
            foreach ($sourceAttributes as $attribute) {
                $slugArr[] = $this->getSluggableSourceAttributeValue($attribute);
            }

            $slug = implode(' ', $slugArr);
            $slug = substr($slug, 0, $maxLength);
            $slug = Str::slug($slug, $this->getSluggableSeparator());
        } else {
            $slug = $this->{$slugAttribute};
        }

        if (empty($slug)) {
            throw new Exception('Slug attribute [$slugAttribute] can not be empty.');
        }

        return $this->{$slugAttribute} = $this->getSluggableUniqueAttributeValue($slugAttribute, $slug);
    }
}
