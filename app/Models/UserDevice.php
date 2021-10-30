<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Jenssegers\Agent\Agent;

    class UserDevice extends Model
    {
        public $timestamps = [
            'last_active_at'
        ];
        protected $fillable = [
            'user_id',
            'ip',
            'user_agent'
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function getUserAgent()
        {
            if ( ! $this->user_agent) {
                return 'Unknown';
            }
            $agent = new Agent();
            $agent->setUserAgent($this->user_agent);

            return $agent;
        }
    }
