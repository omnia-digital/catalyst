<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $NAME
     * @property int    $READ_LOCKED_BY_COUNT
     */
    class RwlockInstance extends Model
    {
        /**
         * Indicates if the model should be timestamped.
         *
         * @var boolean
         */
        public $timestamps = false;
        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'rwlock_instances';
        /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'OBJECT_INSTANCE_BEGIN';
        /**
         * Attributes that should be mass-assignable.
         *
         * @var array
         */
        protected $fillable = [
            'NAME',
            'WRITE_LOCKED_BY_THREAD_ID',
            'READ_LOCKED_BY_COUNT'
        ];
        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = [

        ];
        /**
         * The attributes that should be casted to native types.
         *
         * @var array
         */
        protected $casts = [
            'NAME'                 => 'string',
            'READ_LOCKED_BY_COUNT' => 'int'
        ];
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = [

        ];

        // Scopes...

        // Functions ...

        // Relations ...
    }
