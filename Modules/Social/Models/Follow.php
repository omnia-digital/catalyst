<?php

    namespace Modules\Social\Models;

    use Illuminate\Database\Eloquent\Model;

    class Follow extends Model
    {
        /**
         * @var string[]
         *
         * @psalm-var array{0: 'profile_id', 1: 'following_id', 2: 'local_profile'}
         */
        protected array $fillable = ['profile_id', 'following_id', 'local_profile'];

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
    }
