<?php

    namespace Modules\Social\Models;

    use Illuminate\Database\Eloquent\Model;

    class Follow extends Model
    {
        protected $fillable = ['profile_id', 'following_id', 'local_profile'];

        public function actor()
        {
            return $this->belongsTo(Profile::class, 'profile_id', 'id');
        }

        public function target()
        {
            return $this->belongsTo(Profile::class, 'following_id', 'id');
        }

        public function profile()
        {
            return $this->belongsTo(Profile::class, 'following_id', 'id');
        }

        public function permalink($append = null)
        {
            $path = $this->actor->permalink("#accepts/follows/{$this->id}{$append}");

            return url($path);
        }

        public function toText()
        {
            $actorName = $this->actor->handle;

            return "{$actorName} " . \Trans::get('notification.startedFollowingYou');
        }

        public function toHtml()
        {
            $actorName = $this->actor->handle;
            $actorUrl  = $this->actor->url();

            return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . \Trans::get('notification.startedFollowingYou');
        }
    }
