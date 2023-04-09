<?php

namespace App\Models;

    use Laravel\Jetstream\Membership as JetstreamMembership;
    use Spatie\Permission\Models\Role;

    class Membership extends JetstreamMembership
    {
        //public $incrementing = true;

        protected $table = 'model_has_roles';

        protected $foreignKey = 'model_id';

        public function user()
        {
            return $this->morphTo(User::class, 'model');
        }

        public function role()
        {
            return $this->belongsTo(Role::class);
        }

        public function team()
        {
            return $this->belongsTo(Team::class);
        }
    }
