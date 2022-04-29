<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Laravel\Jetstream\Events\TeamCreated;
    use Laravel\Jetstream\Events\TeamDeleted;
    use Laravel\Jetstream\Events\TeamUpdated;
    use Laravel\Jetstream\Team as JetstreamTeam;
    use Modules\Resources\Models\Resource;

    /**
     * Projects are just Teams
     */
    class Team extends JetstreamTeam
    {
        use HasFactory;

        /**
         * The attributes that should be cast.
         *
         * @var array
         */
        protected $casts = [
            'personal_team' => 'boolean',
        ];

        /**
         * The attributes that are mass assignable.
         *
         * @var string[]
         */
        protected $fillable = [
            'name',
            'personal_team',
            'description',
            'thumbnail'
        ];

        /**
         * The event map for the model.
         *
         * @var array
         */
        protected $dispatchesEvents = [
            'created' => TeamCreated::class,
            'updated' => TeamUpdated::class,
            'deleted' => TeamDeleted::class,
        ];

        public function getThumbnailAttribute($value)
        {
            if (empty($value)) {
                return 'https://via.placeholder.com/200';
            }

            return $value;
        }

        public function resources(): HasMany
        {
            return $this->hasMany(Resource::class);
        }

        public function projectLink() {
            return route('projects.show', $this->id);
        }
    }
