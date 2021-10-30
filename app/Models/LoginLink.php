<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property string $key
     * @property string $secret
     * @property string $ip
     * @property string $user_agent
     * @property int    $user_id
     * @property int    $revoked_at
     * @property int    $resent_at
     * @property int    $used_at
     * @property int    $created_at
     * @property int    $updated_at
     */
    class LoginLink extends Model
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
        protected $table = 'login_links';
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
            'key',
            'secret',
            'user_id',
            'ip',
            'user_agent',
            'meta',
            'revoked_at',
            'resent_at',
            'used_at',
            'created_at',
            'updated_at'
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
            'secret'     => 'string',
            'user_id'    => 'int',
            'ip'         => 'string',
            'user_agent' => 'string',
            'revoked_at' => 'timestamp',
            'resent_at'  => 'timestamp',
            'used_at'    => 'timestamp',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp'
        ];
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = [
            'revoked_at',
            'resent_at',
            'used_at',
            'created_at',
            'updated_at'
        ];

        // Scopes...

        // Functions ...

        // Relations ...
    }
