<?php

namespace Modules\Billing\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Billing\Database\factories\ChargentSubscriptionFactory;

class ChargentSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'next_invoice_at' => 'datetime',
        'ends_at' => 'datetime',
        'last_transaction_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return ChargentSubscriptionFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'Recurring';
    }
}
