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

        /**
         * @var string[]
         *
         * @psalm-var array{0: 'user_id', 1: 'likable_id', 2: 'likable_type', 3: 'liked', 4: 'deleted_at', 5: 'created_at', 6: 'updated_at'}
         */
        protected $fillable = ['user_id', 'likable_id', 'likable_type', 'liked', 'deleted_at', 'created_at', 'updated_at'];
    }
