<?php

namespace Modules\Subscriptions\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chargent_subscriptions';
    
    protected static function newFactory()
    {
        return \Modules\Subscriptions\Database\factories\SubscriptionFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(SubscriptionType::class);
    }
}
