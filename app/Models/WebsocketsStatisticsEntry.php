<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property int    $id
     * @property int    $peak_connection_count
     * @property int    $websocket_message_count
     * @property int    $api_message_count
     * @property int    $created_at
     * @property int    $updated_at
     * @property string $app_id
     */
    class WebsocketsStatisticsEntry extends Model
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
        protected $table = 'websockets_statistics_entries';
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
            'app_id',
            'peak_connection_count',
            'websocket_message_count',
            'api_message_count',
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
            'id'                      => 'int',
            'app_id'                  => 'string',
            'peak_connection_count'   => 'int',
            'websocket_message_count' => 'int',
            'api_message_count'       => 'int',
            'created_at'              => 'timestamp',
            'updated_at'              => 'timestamp'
        ];
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = [
            'created_at',
            'updated_at'
        ];

        // Scopes...

        // Functions ...

        // Relations ...
    }
