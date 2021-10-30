<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $VARIABLE_NAME
     * @property string $VARIABLE_VALUE
     */
    class StatusByUser extends Model
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
        protected $table = 'status_by_user';
        /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = '';
        /**
         * Attributes that should be mass-assignable.
         *
         * @var array
         */
        protected $fillable = [
            'USER',
            'VARIABLE_NAME',
            'VARIABLE_VALUE'
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
            'VARIABLE_NAME'  => 'string',
            'VARIABLE_VALUE' => 'string'
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
