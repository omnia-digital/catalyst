<?php

    namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Like extends Model
    {
        use SoftDeletes;

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];
        protected $fillable = ['user_id', 'likable_id', 'likable_type', 'liked', 'deleted_at', 'created_at', 'updated_at'];

        public function actor()
        {
            return $this->belongsTo(Profile::class, 'profile_id', 'id');
        }

        public function status()
        {
            return $this->belongsTo(Status::class);
        }

        public function toText($type = 'post')
        {
            $actorName = $this->actor->handle;
            $msg       = $type == 'post' ? __('notification.likedPhoto') : __('notification.likedComment');

            return "{$actorName} " . $msg;
        }

        public function toHtml($type = 'post')
        {
            $actorName = $this->actor->handle;
            $actorUrl  = $this->actor->url();
            $msg       = $type == 'post' ? __('notification.likedPhoto') : __('notification.likedComment');

            return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . $msg;
        }

        public function likable() {
            return $this->morphTo();
        }

        public function user() {
            return $this->belongsTo(User::class);
        }

        public function posts() {
            return $this->hasOne(Post::class, 'id', 'likable_id');
        }
    }
