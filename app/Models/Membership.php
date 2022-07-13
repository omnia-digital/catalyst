<?php

    namespace App\Models;

    use Laravel\Jetstream\Membership as JetstreamMembership;

    class Membership extends JetstreamMembership
    {
        public $incrementing = true;

        protected $table = 'model_has_roles';

        protected $foreignKey = 'model_id';

        public function user()
        {
            return $this->belongsTo(User::class,'user_id')->where('model_type',User::class);
        }

        public function team()
        {
            return $this->belongsTo(Team::class);
        }
    }
