<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Jetstream\HasTeams;

    class User extends Authenticatable
    {
        use Notifiable, SoftDeletes, HasFactory, HasTeams;

        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at', 'email_verified_at', '2fa_setup_at'];

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'email',
            'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'email',
            'password',
            'is_admin',
            'remember_token',
            'email_verified_at',
            '2fa_enabled',
            '2fa_secret',
            '2fa_backup_codes',
            '2fa_setup_at',
            'deleted_at',
            'updated_at'
        ];

        public function profile()
        {
            return $this->hasOne(Profile::class);
        }

        public function url()
        {
            return url(config('app.url') . '/' . $this->handle);
        }

        public function receivesBroadcastNotificationsOn()
        {
            return 'App.User.' . $this->id;
        }

        public function storageUsedKey()
        {
            return 'profile:storage:used:' . $this->id;
        }

        public function settings()
        {
            return $this->hasOne(UserSetting::class);
        }

        public function statuses()
        {
            return $this->hasManyThrough(Status::class, Profile::class);
        }

        public function filters()
        {
            return $this->hasMany(UserFilter::class, 'user_id', 'profile_id');
        }

        public function devices()
        {
            return $this->hasMany(UserDevice::class);
        }

        public function accountLog()
        {
            return $this->hasMany(AccountLog::class);
        }

        public function interstitials()
        {
            return $this->hasMany(AccountInterstitial::class);
        }
    }
