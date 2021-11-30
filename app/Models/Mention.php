<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Mention extends Model
    {
        use SoftDeletes;

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];

        public function profile()
        {
            return $this->belongsTo(Profile::class, 'profile_id', 'id');
        }

        public function status()
        {
            return $this->belongsTo(Status::class, 'status_id', 'id');
        }

        public function toText()
        {
            $actorName = $this->status->profile->handle;

            return "{$actorName} " . __('notification.mentionedYou');
        }

        public function toHtml()
        {
            $actorName = $this->status->profile->handle;
            $actorUrl  = $this->status->profile->url();

            return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . __('notification.mentionedYou');
        }
    }
