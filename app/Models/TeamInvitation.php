<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Laravel\Jetstream\Jetstream;
    use Laravel\Jetstream\TeamInvitation as JetstreamTeamInvitation;

    class TeamInvitation extends JetstreamTeamInvitation
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var string[]
         */
        protected $fillable = [
            'email',
            'role',
            'inviter_id',
            'user_id',
            'message',
        ];

        /**
         * Get the user that was invited.
         *
         * @return BelongsTo
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        /**
         * Get the user who sent the invitation.
         *
         * @return BelongsTo
         */
        public function inviter(): BelongsTo
        {
            return $this->belongsTo(User::class, 'inviter_id');
        }

        /**
         * Get the team that the invitation belongs to.
         *
         * @return BelongsTo
         */
        public function team()
        {
            return $this->belongsTo(Jetstream::teamModel());
        }
    }
