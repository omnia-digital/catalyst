<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $key
     * @property string $owner
     * @property int    $expiration
     */
    class CacheLock extends Model
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
        protected $table = 'cache_locks';
        /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'key';
        /**
         * Attributes that should be mass-assignable.
         *
         * @var array
         */
        protected $fillable = [
            'owner',
            'expiration'
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
            'key'        => 'string',
            'owner'      => 'string',
            'expiration' => 'int'
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
