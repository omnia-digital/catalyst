<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;

    class Association extends Model
    {
        protected $fillable = [
            'targetable_type',
            'targetable_id',
            'associatable_type',
            'associatable_id',
        ];

        public function targetable()
        {
            return $this->morphTo();
        }

        public function associatable()
        {
            $this->morphTo();
        }
    }
