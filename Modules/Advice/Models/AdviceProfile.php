<?php

    namespace Advice\App\Models;

    use Illuminate\Database\Eloquent\Model;

    class AdviceProfile extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'advice_profiles';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'bio',
            'person_id',
        ];

        public function getCredibilityRatingAttribute(): void
        {

        }

        public function person(): void
        {
            $this->belongsTo(Person::class);
        }
    }
