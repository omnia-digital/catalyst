<?php

    namespace Modules\Social\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Social\Database\Factories\CommentFactory;

    class Comment extends Model
    {
        use HasFactory;

        protected $fillable = ['user_id', 'parent_id', 'body', 'commentable_id', 'commentable_type'];

        protected static function newFactory()
        {
            return CommentFactory::new();
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function profile()
        {
            return $this->belongsTo(Profile::class);
        }

        public function commentable()
        {
            return $this->morphTo();
        }

        public function status()
        {
            return $this->belongsTo(Status::class);
        }
    }
