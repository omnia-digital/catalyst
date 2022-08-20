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

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<Profile>
         */
        public function actor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Profile::class, 'profile_id', 'id');
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<Status>
         */
        public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Status::class);
        }

        public function toText($type = 'post'): string
        {
            $actorName = $this->actor->handle;
            $msg       = $type == 'post' ? \Trans::get('notification.likedPhoto') : \Trans::get('notification.likedComment');

            return "{$actorName} " . $msg;
        }

        public function toHtml($type = 'post'): string
        {
            $actorName = $this->actor->handle;
            $actorUrl  = $this->actor->url();
            $msg       = $type == 'post' ? \Trans::get('notification.likedPhoto') : \Trans::get('notification.likedComment');

            return "<a href='{$actorUrl}' class='profile-link'>{$actorName}</a> " . $msg;
        }

        public function likable(): \Illuminate\Database\Eloquent\Relations\MorphTo
        {
            return $this->morphTo();
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
         */
        public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        /**
         * @psalm-return \Illuminate\Database\Eloquent\Relations\HasOne<Post>
         */
        public function post(): \Illuminate\Database\Eloquent\Relations\HasOne
        {
            return $this->hasOne(Post::class, 'id', 'likable_id');
        }
    }
