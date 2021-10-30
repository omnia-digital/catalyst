<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Bookmark extends Model
    {
        protected $fillable = ['profile_id', 'status_id'];

        public function status()
        {
            return $this->belongsTo(Status::class);
        }


        public function profile()
        {
            return $this->belongsTo(Profile::class);
        }
    }
