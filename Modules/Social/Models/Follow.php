<?php

    namespace Modules\Social\Models;

    use Illuminate\Database\Eloquent\Model;

    class Follow extends Model
    {
        protected $fillable = ['profile_id', 'following_id', 'local_profile'];

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<Profile>
         */
        public function actor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Profile::class, 'profile_id', 'id');
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<Profile>
         */
        public function target(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Profile::class, 'following_id', 'id');
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<Profile>
         */
        public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Profile::class, 'following_id', 'id');
        }

        public function permalink($append = null): string
        {
            $path = $this->actor->permalink("#accepts/follows/{$this->id}{$append}");

            return url($path);
        }

        public function toText(): string
        {
            $actorName = $this->actor->handle;

            return "{$actorName} " . \Trans::get('notification.startedFollowingYou');
        }

        public function toHtml(): string
        {
            $actorName = $this->actor->handle;
            $actorUrl  = $this->actor->url();

            return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . \Trans::get('notification.startedFollowingYou');
        }
    }
