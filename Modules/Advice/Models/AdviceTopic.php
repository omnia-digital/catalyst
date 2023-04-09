<?php

namespace Advice\App\Models;

    use Advise\App\Certification;
    use Illuminate\Database\Eloquent\Model;

    class AdviceTopic extends Model
    {
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'advice_topics';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'certification_id',
        ];

        public function certifications()
        {
            $this->belongsTo(Certification::class, 'certification_id');
        }
    }
