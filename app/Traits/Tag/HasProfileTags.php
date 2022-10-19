<?php

    namespace App\Traits\Tag;

    use Illuminate\Database\Eloquent\Relations\MorphToMany;

    trait HasProfileTags
    {
        public function profileTags()
        {
            return $this
                ->morphToMany(self::getTagClassName(), 'taggable')
                ->where('type', 'profile_type')
                ->ordered();
        }

        public function tags(): MorphToMany
        {
            return $this->profileTags();
        }
    }
