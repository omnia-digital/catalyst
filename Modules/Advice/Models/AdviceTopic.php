<?php

    namespace Advice\App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Advise\App\Certification;

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

        public function certifications(): void
        {
            $this->belongsTo(Certification::class,'certification_id');
        }

    }
