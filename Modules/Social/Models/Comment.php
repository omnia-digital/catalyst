<?php

    namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Comment extends Model
    {
        use HasFactory;

        protected $fillable = [];
        
        protected static function newFactory()
        {
            return \Modules\Social\Database\factories\CommentFactory::new();
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function profile()
        {
            return $this->belongsTo(Profile::class);
        }

        public function commentable() {
            return $this->morphTo();
        }

        public function status()
        {
            return $this->belongsTo(Status::class);
        }
    }
