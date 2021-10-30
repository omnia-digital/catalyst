<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $queue
     * @property string $payload
     * @property int    $attempts
     * @property int    $reserved_at
     * @property int    $available_at
     * @property int    $created_at
     */
    class Job extends Model
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
        protected $table = 'jobs';
        /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'id';
        /**
         * Attributes that should be mass-assignable.
         *
         * @var array
         */
        protected $fillable = [
            'queue',
            'payload',
            'attempts',
            'reserved_at',
            'available_at',
            'created_at'
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
            'queue'        => 'string',
            'payload'      => 'string',
            'attempts'     => 'int',
            'reserved_at'  => 'int',
            'available_at' => 'int',
            'created_at'   => 'int'
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
