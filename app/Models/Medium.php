<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    /**
     * @property int     $id
     * @property int     $order
     * @property int     $size
     * @property int     $processed_at
     * @property int     $hls_transcoded_at
     * @property int     $created_at
     * @property int     $updated_at
     * @property int     $deleted_at
     * @property int     $version
     * @property int     $width
     * @property int     $height
     * @property int     $replicated_at
     * @property boolean $is_nsfw
     * @property boolean $remote_media
     * @property boolean $skip_optimize
     * @property string  $original_sha256
     * @property string  $optimized_sha256
     * @property string  $media_path
     * @property string  $thumbnail_path
     * @property string  $cdn_url
     * @property string  $optimized_url
     * @property string  $thumbnail_url
     * @property string  $remote_url
     * @property string  $caption
     * @property string  $hls_path
     * @property string  $mime
     * @property string  $orientation
     * @property string  $filter_name
     * @property string  $filter_class
     * @property string  $license
     * @property string  $key
     * @property string  $blurhash
     */
    class Medium extends Model
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
        protected $table = 'media';
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
            'status_id',
            'profile_id',
            'user_id',
            'is_nsfw',
            'remote_media',
            'original_sha256',
            'optimized_sha256',
            'media_path',
            'thumbnail_path',
            'cdn_url',
            'optimized_url',
            'thumbnail_url',
            'remote_url',
            'caption',
            'hls_path',
            'order',
            'mime',
            'size',
            'orientation',
            'filter_name',
            'filter_class',
            'license',
            'processed_at',
            'hls_transcoded_at',
            'created_at',
            'updated_at',
            'deleted_at',
            'key',
            'metadata',
            'version',
            'blurhash',
            'srcset',
            'width',
            'height',
            'skip_optimize',
            'replicated_at'
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
            'id'                => 'int',
            'is_nsfw'           => 'boolean',
            'remote_media'      => 'boolean',
            'original_sha256'   => 'string',
            'optimized_sha256'  => 'string',
            'media_path'        => 'string',
            'thumbnail_path'    => 'string',
            'cdn_url'           => 'string',
            'optimized_url'     => 'string',
            'thumbnail_url'     => 'string',
            'remote_url'        => 'string',
            'caption'           => 'string',
            'hls_path'          => 'string',
            'order'             => 'int',
            'mime'              => 'string',
            'size'              => 'int',
            'orientation'       => 'string',
            'filter_name'       => 'string',
            'filter_class'      => 'string',
            'license'           => 'string',
            'processed_at'      => 'timestamp',
            'hls_transcoded_at' => 'timestamp',
            'created_at'        => 'timestamp',
            'updated_at'        => 'timestamp',
            'deleted_at'        => 'timestamp',
            'key'               => 'string',
            'version'           => 'int',
            'blurhash'          => 'string',
            'width'             => 'int',
            'height'            => 'int',
            'skip_optimize'     => 'boolean',
            'replicated_at'     => 'timestamp'
        ];
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = [
            'processed_at',
            'hls_transcoded_at',
            'created_at',
            'updated_at',
            'deleted_at',
            'replicated_at'
        ];

        // Scopes...

        // Functions ...

        // Relations ...
    }
